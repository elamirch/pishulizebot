<?php
ini_set('display_errors', "on");
error_reporting(E_ALL);
$HOST=$_ENV["HOST"];
$USER=$_ENV["USER"];
$PASS=$_ENV["PASS"];
$DB=$_ENV["DB"];

$pdo = new PDO("mysql:host=$HOST;port=3306;dbname=$DB", $USER, $PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "Running\n";

$BOT_TOKEN = $_ENV["BOT_TOKEN"];
$last_update_id = 0;
require_once("./buttons.php");


function send($method, $data){
    global $BOT_TOKEN;
    $url = "https://api.telegram.org/bot$BOT_TOKEN/$method";
    if(!$curld = curl_init()){
        exit;
    }
    curl_setopt($curld, CURLOPT_POST, true);
    curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curld, CURLOPT_URL, $url);
    curl_setopt($curld, CURLOPT_PROXY, '127.0.0.1');
    curl_setopt($curld, CURLOPT_PROXYPORT, 2081);
    curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curld);
    curl_close($curld);
    echo "\n$method\n$output\n\n";
    return $output;
}

function download_file($sender, $file_path){
    global $BOT_TOKEN;
    global $pdo;

    $url = "https://api.telegram.org/file/bot$BOT_TOKEN/$file_path"; 
    mkdir($sender);
    $file_name = uniqid() . basename($url); 
    $scont = stream_context_create(array(
        'http' => array(
            'proxy'           => 'tcp://127.0.0.1:2081',
            'request_fulluri' => true,
        ),
    ));
    if (file_put_contents($sender . "/" . $file_name ,
        file_get_contents($url, False, $scont)))
    { 
        echo "File downloaded successfully";
        $stmt = $pdo->prepare('UPDATE `senders` SET `background`=:fn WHERE user_id=:ui;');
        $stmt->execute(array(':fn' => $file_name, ':ui' => $sender));
        return True;
    } 
    else
    { 
        echo "File downloading failed.";
        return False;
    } 
}


function create_input_video($sender, $background, $meme_overlay_path) {
    
    exec("ffprobe -v error -select_streams v -show_entries stream=width,height -of json $sender/$background", $ff_output);
    $height = json_decode(implode(" ", $ff_output))->streams[0]->height;
    $width = json_decode(implode(" ", $ff_output))->streams[0]->width;
    echo "\n width: " . $width . " height: " . $height;

    if($height > $width*1.77777) {
        //for a too long vertical image
        //scale to 576 wide
        exec("ffmpeg -i $sender/$background -vf \"scale=576:trunc(ow/a/2)*2\" -c:v libx264 -c:a copy $sender/scaled.mp4");
    } else {
        //for a horizontal image or short vertical image
        //scale to 1024 high
        exec("ffmpeg -i $sender/$background -vf \"scale=trunc(oh*a/2)*2:1024\" -c:v libx264 -c:a copy $sender/scaled.mp4");
    }

    //crop to 576x1024
    exec("ffmpeg -i $sender/scaled.mp4 -filter:v \"crop=576:1024:1:1\" $sender/cropped.mp4");
    //add overlay
    exec("ffmpeg -i $sender/cropped.mp4 -i $meme_overlay_path -filter_complex \"[0:v][1:v]overlay=0:0[v]\" -map \"[v]\" -map 1:a -c:v libx264 -c:a aac -strict -2 $sender/input.mp4");

    unlink("$sender/$background");
    unlink("$sender/cropped.mp4");
    unlink("$sender/scaled.mp4");
}

//this function breaks strings by the given chunk size so that the 
//text written to the output video will stay within the video's resolution
function break_string($string, $chunk_size) {
    $lines = array();
    $lines[0] = '';
    $words = mb_split(" ", $string);
    $i = 0;
    foreach($words as $key=>$word) {
        if(mb_strlen($lines[$i]) + mb_strlen($word) < $chunk_size) {
            $lines[$i] = $lines[$i] . $word . " ";
        } else {
            $i++;
            $lines[$i] = $word . ' ';
        }
    }
    return $lines;
}

function add_texts_tkt($texts, $sender) {
    //add texts

    $dada_one = str_replace('0@0', "\n", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[0]))));
    $meow_one = str_replace('0@0', "\n", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[1]))));
    $dada_two = str_replace('0@0', "\n", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[2]))));
    $meow_two = str_replace('0@0', "\n", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[3]))));
    $meow_three = str_replace('0@0', "\n", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[4]))));

    $output_file = uniqid("output");
    exec("ffmpeg -i $sender/input.mp4 -vf \"" .
    "drawtext=text='$dada_one':fontfile=Vazirmatn-Regular.ttf:fontsize=32" .
    ":fontcolor=black:x=80:y=320:box=1:boxcolor=white@0.8:enable='between(t,0,2)':text_align=R, drawtext=text='$meow_one':" .
    "fontfile=Vazirmatn-Regular.ttf:fontsize=32:fontcolor=black:x=380:y=350:box=1:boxcolor=white@0.8:enable='between(t,2.8,4)':text_align=R," .
    "drawtext=text='$dada_two':fontfile=Vazirmatn-Regular.ttf:fontsize=32:" .
    "fontcolor=black:x=80:y=320:box=1:boxcolor=white@0.8:enable='between(t,4.5,8.5)':text_align=R, drawtext=text='$meow_two':" .
    "fontfile=Vazirmatn-Regular.ttf:fontsize=32:fontcolor=black:x=380:y=350:box=1:boxcolor=white@0.8:enable='between(t,8.7,10)':text_align=R," .
    "drawtext=text='$meow_three':fontfile=Vazirmatn-Regular.ttf:fontsize=32:fontcolor=black:x=380:y=350:" .
    "box=1:boxcolor=white@0.8:enable='between(t,11,12)':text_align=R\" -c:v libx264 -c:a copy $sender/$output_file.mp4 2>&1", $op);

    unlink("$sender/input.mp4");
    return $output_file;
}

function add_texts_type2($text, $sender) {
    //add texts

    $text_refined = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text))));
    $output_file = uniqid("output");
    exec("ffmpeg -i $sender/input.mp4 -vf \"drawtext=text='$text_refined':fontfile=Vazirmatn-Regular.ttf:fontsize=36:" .
    "fontcolor=black:x=50:y=150:box=1:boxcolor=white@0.8:boxborderw=5:text_align=R\" -c:v libx264 -c:a " .
    "copy $sender/$output_file.mp4 2>&1", $op);

    unlink("$sender/input.mp4");
    return $output_file;
}

function send_result_video($sender, $output_file) {
    global $BOT_TOKEN;
    $videoPath = "$sender/$output_file.mp4";

    // Create a cURL handle
    $curl = curl_init();
    // Set the cURL options
    curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.telegram.org/bot$BOT_TOKEN/sendVideo",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
            'chat_id' => "$sender",
            'video' => new \CURLFile($videoPath),
            'caption' => "ویدیوی شما با موفقیت ساخته شد: @pishulizebot",
        ],
    ]);

    // Execute the cURL request
    $response = curl_exec($curl);
    // Check if an error occurred
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        echo $error;
        // Handle the error appropriately
    }

    // Close the cURL handle
    curl_close($curl);
    // Process the response from the Telegram Bot API
    unlink($videoPath);
}

function create_photo_meme($text, $sender, $meme_overlay_path) {
    $text_refined = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text))));
    $output_file = uniqid("output");
    
    exec("ffmpeg -i $meme_overlay_path -vf \"drawtext=text='$text_refined':" .
    "fontfile=Vazirmatn-Regular.ttf:fontsize=36:fontcolor=black:x=50:y=50:box=1:" .
    "boxcolor=white@0.8:boxborderw=5:text_align=R,format=rgb24\" -frames:v 1 $sender/$output_file.png", $op);
    return $output_file;
}

function create_distracted_bf_meme($text, $sender) {
    $text_1_dbf = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[0]))));
    $text_2_dbf = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[1]))));
    $text_3_dbf = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[2]))));
    $output_file = uniqid("output");
    
    exec("ffmpeg -i memes/14-distracted-boyfriend/distracted-boyfriend.png -vf \"drawtext=text='$text_1_dbf':fontfile=".
    "Vazirmatn-Regular.ttf:fontsize=24:fontcolor=black:x=630:y=310:box=1:boxcolor=white@0.8:".
    "boxborderw=5:text_align=R,drawtext=text='$text_2_dbf':fontfile=Vazirmatn-Regular.ttf:fontsize=24:fontcolor=".
    "black:x=430:y=260:box=1:boxcolor=white@0.8:boxborderw=5:text_align=R,drawtext=text='$text_3_dbf':".
    "fontfile=Vazirmatn-Regular.ttf:fontsize=36:fontcolor=black:x=100:y=400:box=1:".
    "boxcolor=white@0.8:boxborderw=5:text_align=R,format=rgb24\" -frames:v 1 $sender/$output_file.png", $op);
    return $output_file;
}

function create_drakepost_meme($text, $sender) {
    $text_1_dp = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[0]))));
    $text_2_dp = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[1]))));
    $output_file = uniqid("output");
    
    exec("ffmpeg -i memes/16-drakepost/drakepost.png -vf \"drawtext=text='$text_1_dp':fontfile=".
    "Vazirmatn-Regular.ttf:fontsize=36:fontcolor=black:x=400:y=50:box=1:boxcolor=white@0.8:".
    "boxborderw=5:text_align=R,drawtext=text='$text_2_dp':fontfile=Vazirmatn-Regular.ttf:fontsize=36:fontcolor=".
    "black:x=400:y=450:box=1:boxcolor=white@0.8:boxborderw=5:text_align=R,format=rgb24\" -frames:v 1 $sender/$output_file.png", $op);
    return $output_file;
}

function create_exit12_meme($text, $sender) {
    $text_1_e12 = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[0]))));
    $text_2_e12 = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[1]))));
    $text_3_e12 = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[2]))));
    $output_file = uniqid("output");
    
    exec("ffmpeg -i memes/17-exit-12/exit-12.png -vf \"drawtext=text='$text_1_e12':fontfile=Vazirmatn-Regular.ttf".
    ":fontsize=24:fontcolor=black:x=200:y=120:box=1:boxcolor=white@0.8:boxborderw=5:text_align=R,".
    "drawtext=text='$text_2_e12':fontfile=Vazirmatn-Regular.ttf:fontsize=24:fontcolor=black".
    ":x=420:y=120:box=1:boxcolor=white@0.8:boxborderw=5:text_align=R,drawtext=text='$text_3_e12':fontfile".
    "=Vazirmatn-Regular.ttf:fontsize=24:fontcolor=black:x=335:y=540:box=1:boxcolor=".
    "white@0.8:boxborderw=5:text_align=R,format=rgb24\" -frames:v 1 $sender/$output_file.png", $op);
    return $output_file;
}

function create_hide_the_pain_meme($text, $sender) {
    $text_1_hdp = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[0]))));
    $text_2_hdp = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text[1]))));
    $output_file = uniqid("output");
    
    exec("ffmpeg -i memes/19-hide-the-pain-harold/hide-the-pain-harold.png -vf \"drawtext=text='$text_1_hdp':fontfile=Vazirmatn-Regular.ttf".
    ":fontsize=45:fontcolor=black:x=110:y=100:box=1:boxcolor=white@0.8:boxborderw=5,drawtext=text='$text_2_hdp'".
    ":fontfile=Vazirmatn-Regular.ttf:fontsize=45:fontcolor=black:x=210:y=1180:box=1:boxcolor=white@0.8:".
    "boxborderw=5:text_align=R,format=rgb24\" -frames:v 1 $sender/$output_file.png", $op);
    return $output_file;
}

function send_result_photo($sender, $output_file) {
    global $BOT_TOKEN;
    $photoPath = "$sender/$output_file.png";

    // Create a cURL handle
    $curl = curl_init();
    // Set the cURL options
    curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.telegram.org/bot$BOT_TOKEN/sendPhoto",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
            'chat_id' => "$sender",
            'photo' => new \CURLFile($photoPath),
            'caption' => "میم شما با موفقیت ساخته شد: @pishulizebot",
        ],
    ]);

    // Execute the cURL request
    $response = curl_exec($curl);
    // Check if an error occurred
    if (curl_errno($curl)) {
        $error = curl_error($curl);
        echo $error;
        // Handle the error appropriately
    }

    // Close the cURL handle
    curl_close($curl);
    // Process the response from the Telegram Bot API
    unlink($photoPath);
}


while(true) {
    sleep(2);
$last_update_id = $pdo->query("SELECT * FROM `last_update_id` ORDER BY `id` DESC LIMIT 1")->fetchAll()[0]['update_id'];
$last_update_id++;

//if there are new updates, do the job, if there are none, don't update 'last_update_id' table
$updates = json_decode(send("getUpdates", "offset=$last_update_id"))->result ?? False;
if($updates) {
foreach($updates as $update) {
    $last_update_id = $update->update_id;
    $sender = $update->message->from->id ?? $update->callback_query->from->id;

    if (json_decode(send("getChatMember", "chat_id=@pishulize&user_id=$sender"))->result->status == "left") {
        send("sendMessage", "chat_id=$sender&text=برای استفاده از بات لطفا در کانال پیشولیزه عضو شوید و دوباره دکمه استارت را بزنید:\n@pishulize");
    } elseif(isset($update->message->text)) {
        switch($update->message->text) {
            case '/start':
                // on /start command
                $image_id = 'AgACAgQAAxkBAAIDKGX-5d_coeosIu4Vluh6raWJQFD-AAKPwjEby9X5U0sjdscR_FXFAQADAgADeQADNAQ';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_selector_markup_encoded&caption=انتخاب کنید");
                if ($pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0] != null) {
                    echo "\n New Message \n";
                } else {
                    $stmt = $pdo->prepare("INSERT INTO `senders` (`user_id`, `checkpoint`) VALUES (:si, 0);");
                    $stmt->execute(array(':si' => $sender));
                    echo '\nnew user\n';
                    mkdir($sender, 0755, true);
                }
                break;
            case '۱- دو تا پیشی در حال صحبت':
                $image_id = 'BAACAgQAAxkBAAIDLGX-5j18EzH8dGE2z7YRWIGy-IW6AAIfFAACy9X5U2bIxOa_8MFJNAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$tkt_meme_setting_markup_encoded&caption=انتخاب کنید");
                break;
            case '۲- Brother Eww!':
                $image_id = 'BAACAgQAAxkBAAIDMGX-5omeYoXjQsHGD8SDZY3r2xrMAAIgFAACy9X5U9xVjb5NzO55NAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_2_encoded&caption=انتخاب کنید");
                break;
            case '۳- سیس گرفتن راک':
                $image_id = 'BAACAgQAAxkBAAIDMWX-5ruXOgg5As-sh8oassXXv8zCAAIhFAACy9X5U-HVkjvZFi3rNAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_3_encoded&caption=انتخاب کنید");
                break;
            case '۴- نیکولاس کیج و پدرو پاسکال':
                $image_id = 'BAACAgQAAxkBAAIDMmX-5tkzrQT01tEeHXWGZPpcrmTcAAIiFAACy9X5U1IAAdKb2GPSmTQE';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_4_encoded&caption=انتخاب کنید");
                break;
            case '۵- شوکه شدن جان سینا':
                $image_id = 'BAACAgQAAxkBAAIDM2X-5u6PIC5BXR3hyfLpQtIEbj0sAAIjFAACy9X5U3aIOfmWIPPeNAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_5_encoded&caption=انتخاب کنید");
                break;
            case '۶- خنده خوان':
                $image_id = 'BAACAgQAAxkBAAIDNGX-5xig8rdjx42u5gzqndrHezS0AAIkFAACy9X5U9h0GfGCpOv_NAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_6_encoded&caption=انتخاب کنید");
                break;
            case '۷- گربه در حال رانندگی':
                $image_id = 'BAACAgQAAxkBAAIDNWX-5zTufUVtJosBxzOmg8iH_yRmAAIlFAACy9X5U-0BjpDmfBvSNAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_7_encoded&caption=انتخاب کنید");
                break;
            case '۸- گربه Mr. Fresh':
                $image_id = 'BAACAgQAAxkBAAIDNmX-52mG2bPfLIV4a9JetPetX9OnAAImFAACy9X5U-sQZGpVKT1tNAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_8_encoded&caption=انتخاب کنید");
                break;
            case '۹- گفتگوی پیشی و بز':
                $image_id = 'BAACAgQAAxkBAAIDN2X-53saPRQGRnTNiT0pJuajmYpXAAInFAACy9X5U4lbdsZ9Z5uqNAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_9_encoded&caption=انتخاب کنید");
                break;
            case '۱۰- پیشی در حال آره گفتن':
                $image_id = 'BAACAgQAAxkBAAIDOGX-54BJrWlgNRe0FX_8YeJG4Pt7AAIoFAACy9X5U1ICM-kTNB3ANAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_10_encoded&caption=انتخاب کنید");
                break;
            case '۱۱- جویدن خر':
                $image_id = 'BAACAgQAAxkBAAIDOWX-54l5_VPBmnQvrP5tOqasL6uQAAIpFAACy9X5UyPyV9TgglJ8NAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_11_encoded&caption=انتخاب کنید");
                break;
            case '۱۲- حسب‌الله در حال شمردن پول':
                $image_id = 'BAACAgQAAxkBAAIDOmX-55AcZrI54_-WrjmlPpBinWylAAIqFAACy9X5U_VgzHw11WDaNAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_12_encoded&caption=انتخاب کنید");
                break;
            case '۱۳- Disaster Girl':
                $image_id = 'AgACAgQAAxkBAAIDO2X-55VcCSxVU8GU65N_0QygrworAAKUwjEby9X5U5bDhd9c1OFLAQADAgADeAADNAQ';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_setting_markup_13_encoded&caption=انتخاب کنید");
                break;
            case '۱۴- دوست پسر چشم چرون':
                $image_id = 'AgACAgQAAxkBAAIDWGX-6LMfrDDc4KVaw6GUUw2l7xHbAAKVwjEby9X5U05AwYGlpVc3AQADAgADeAADNAQ';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_setting_markup_14_encoded&caption=انتخاب کنید");
                break;
            case '۱۵- کرمیت در حال مشاوره شیطانی':
                $image_id = 'AgACAgQAAxkBAAIDWWX-6LxEuvP-J2vs28FNewaZiDtUAAKWwjEby9X5U4Y6falN0By6AQADAgADeQADNAQ';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_setting_markup_15_encoded&caption=انتخاب کنید");
                break;
            case '۱۶- Drakepost':
                $image_id = 'AgACAgQAAxkBAAIDWmX-6MLeMoKHHpKLOr6jZyWjCtF0AAKXwjEby9X5U7i-7zXUf4fwAQADAgADeAADNAQ';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_setting_markup_16_encoded&caption=انتخاب کنید");
                break;
            case '۱۷- خروجی ۱۲':
                $image_id = 'AgACAgQAAxkBAAIDW2X-6McRzbfw_AzV3-RshDs_pCaSAAKYwjEby9X5U_ADHI1FsYQDAQADAgADeAADNAQ';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_setting_markup_17_encoded&caption=انتخاب کنید");
                break;
            case '۱۸- Facepalm':
                $image_id = 'AgACAgQAAxkBAAIDXGX-6Mt2PYQ9GudTkSHjc8QGDGBaAAKZwjEby9X5U6s4FwEIOm3EAQADAgADeAADNAQ';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_setting_markup_18_encoded&caption=انتخاب کنید");
                break;
            case '۱۹- هارولد در حال مخفی کردن درد':
                $image_id = 'AgACAgQAAxkBAAIDXmX-6UajFA4G0zDzLJIMhP82_uVaAAKbwjEby9X5U-Q9RFbjO-tGAQADAgADeQADNAQ';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_setting_markup_19_encoded&caption=انتخاب کنید");
                break;
            case '۲۰- اسپایدرمن':
                $image_id = 'AgACAgQAAxkBAAIDXWX-6NCk86HpAAFy8fjVGDcDdOc2HQACmsIxG8vV-VMAAUMmHtjNPj0BAAMCAAN4AAM0BA';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_setting_markup_20_encoded&caption=انتخاب کنید");
                break;
            case '۲۱- ذکاوت!':
                $image_id = 'AgACAgQAAxkBAAIDjGX-6qn2rkM24wWf-sS3E4W3M69fAAKcwjEby9X5U_MJ-AJ157RUAQADAgADeAADNAQ';
                send("sendPhoto", "chat_id=$sender&photo=$image_id&reply_markup=$meme_setting_markup_21_encoded&caption=انتخاب کنید");
                break;
            case "۲۲- مورینیو: If I speak I'm in big trouble":
                $image_id = 'BAACAgQAAxkBAAIDYGX-6VTnrOwQprW_Qs7FfRPVN6MkAAIsFAACy9X5U-ctl8tLsVxtNAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_22_encoded&caption=انتخاب کنید");
                break;
            case '۲۳- سگ گریان':
                $image_id = 'BAACAgQAAxkBAAIDYWX-6VyNvywKcdsf-SJyIqCcuBQfAAItFAACy9X5UzNErAnKUhutNAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_23_encoded&caption=انتخاب کنید");
                break;
            case '۲۴- دعوای پیشی‌ها':
                $image_id = 'BAACAgQAAxkBAAIDYmX-6WMLsA9EDuSPxXl3JbNE6p0bAAIuFAACy9X5U2Ejc3RchZJ6NAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_24_encoded&caption=انتخاب کنید");
                break;
            case '۲۵- ترامپ: Somebody had to do it, I am the chosen one':
                $image_id = 'BAACAgQAAxkBAAIDY2X-6WbhLyT18oIUEt80oJXRBYfRAAIvFAACy9X5U08fUtw_IUD_NAQ';
                send("sendVideo", "chat_id=$sender&video=$image_id&reply_markup=$meme_setting_markup_25_encoded&caption=انتخاب کنید");
                break;
            default:
                $checkpoint = $pdo->query("SELECT `checkpoint` FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                switch ($checkpoint[0]) {
                    case 'background':
                        echo $sender . "\n";
                        send("sendMessage", "chat_id=$sender&text=لطفا تصویر یا ویدیوی مورد نظر خود را ارسال کنید");
                        break;
                    
                    case 'texts':
                        $stmt = $pdo->prepare("UPDATE `senders` SET `checkpoint` = 0 WHERE `user_id` = :si;");
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `texts` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        send("sendMessage", "chat_id=$sender&text=متن اعمال شد، جهت ساخت میم روی دکمه ساخت کلیک کنید.");
                        break;
                    
                    case 'text1tkt':
                        send("sendMessage", "chat_id=$sender&text=متن اول اعمال شد، متن دوم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2tkt\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_one` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;
                    
                    case 'text2tkt':
                        send("sendMessage", "chat_id=$sender&text=متن دوم اعمال شد، متن سوم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text3tkt\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_two` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;

                    case 'text3tkt':
                        send("sendMessage", "chat_id=$sender&text=متن سوم اعمال شد، متن چهارم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text4tkt\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_three` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;
                    
                    case 'text4tkt':
                        send("sendMessage", "chat_id=$sender&text=متن چهارم اعمال شد، متن پنجم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text5tkt\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_four` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;
                    
                    case 'text5tkt':
                        send("sendMessage", "chat_id=$sender&text=متن پنجم اعمال شد.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0 WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_five` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        # now create it baby!
                        break;

                    case 'text1dbf':
                        send("sendMessage", "chat_id=$sender&text=متن اول اعمال شد، متن دوم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2dbf\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_one` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;
                    
                    case 'text2dbf':
                        send("sendMessage", "chat_id=$sender&text=متن دوم اعمال شد، متن سوم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text3dbf\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_two` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;

                    case 'text3dbf':
                        send("sendMessage", "chat_id=$sender&text=متن سوم اعمال شد.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0 WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_three` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;

                    case 'text1dp':
                        send("sendMessage", "chat_id=$sender&text=متن اول اعمال شد، متن دوم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2dp\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_one` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;
                    
                    case 'text2dp':
                        send("sendMessage", "chat_id=$sender&text=متن دوم اعمال شد.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0 WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_two` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;

                    case 'text1e12':
                        send("sendMessage", "chat_id=$sender&text=متن اول اعمال شد، متن دوم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2e12\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_one` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;
                    
                    case 'text2e12':
                        send("sendMessage", "chat_id=$sender&text=متن دوم اعمال شد، متن سوم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text3e12\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_two` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;
                    
                    case 'text3e12':
                        send("sendMessage", "chat_id=$sender&text=متن سوم اعمال شد.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0 WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_three` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;

                    case 'text1hdp':
                        send("sendMessage", "chat_id=$sender&text=متن اول اعمال شد، متن دوم را بنویسید.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2hdp\' WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_one` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;
                    
                    case 'text2hdp':
                        send("sendMessage", "chat_id=$sender&text=متن دوم اعمال شد.");
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0 WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                        $stmt = $pdo->prepare('UPDATE `senders` SET `text_two` = :tx WHERE `user_id` = :si;');
                        $stmt->execute(array(':tx' => $update->message->text, ':si' => $sender));
                        break;
                    default:
                        # code...
                        break;
                }
                break;
        }
    } elseif(isset($update->callback_query)) {
        switch ($update->callback_query->data) {
            case 'setbackground':
                echo "\n 568 \n";
                send("sendMessage", "chat_id=$sender&text=تصویر یا ویدیوی مورد نظر خود را ارسال کنید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` =:tx WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender, ':tx' => "background"));
                break;
            
            case 'settext':
                send("sendMessage", "chat_id=$sender&text=متن مورد نظر خود را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'texts\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;
            
            case 'create_1':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['text_one'] != null &&
                    $results['text_two'] != null && $results['text_three'] != null &&
                    $results['text_four'] != null && $results['text_five'] != null) {
                        create_input_video($sender, $results['background'], "memes/1-two-kitties-talking/1-tkt.mov");
                        $output_file = add_texts_tkt([break_string($results['text_one'], 35),
                            break_string($results['text_two'], 14),
                            break_string($results['text_three'], 35),
                            break_string($results['text_four'], 14),
                            break_string($results['text_five'], 14)], $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`text_one` = NULL, `text_two` = NULL, `text_three` = NULL, `text_four` = NULL,' .
                            '`text_five` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_2':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/2-brother-eww/2-brother-eww.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_3':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/3-the-rock-sus/3-the-rock-sus.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_4':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/4-cage-and-pascal/4-cage-and-pascal.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_5':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/5-shocked-john-cena/5-shocked-john-cena.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_6':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/6-juan-laughing/6-juan-laughing.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_7':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/7-driving-cat/7-driving-cat.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_8':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/8-mr-fresh-cat/8-mr-fresh-cat.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_9':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/9-goat-and-clueless-cat/9-goat-n-kitty.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_10':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/10-kitty-saying-arreh/10-kitty-saying-arreh.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_11':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/11-donkey-eating/11-donkey-eating.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_12':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/12-hasbulla-counting-money/12-hasbulla-counting-money.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 30), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_13':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['texts'] != null) {
                        $output_file = create_photo_meme(break_string($results['texts'], 40), $sender,
                            "memes/13-disaster-girl/disaster-girl.png");
                        send_result_photo($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_14':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['text_one'] != null && $results['text_two'] != null && $results['text_three'] != null) {
                        $output_file = create_distracted_bf_meme([break_string($results['text_one'], 8),
                            break_string($results['text_two'], 8), break_string($results['text_three'], 8)],
                            $sender, "memes/14-distracted-boyfriend/distracted-boyfriend.png");
                        send_result_photo($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_15':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['texts'] != null) {
                        $output_file = create_photo_meme(break_string($results['texts'], 40), $sender, "memes/15-evil-kermit/evil-kermit.png");
                        send_result_photo($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_16':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['text_one'] != null && $results['text_two'] != null) {
                        $output_file = create_drakepost_meme([break_string($results['text_one'], 22),
                            break_string($results['text_two'], 22)], $sender);
                        send_result_photo($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_17':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['text_one'] != null && $results['text_two'] != null && $results['text_three'] != null) {
                        $output_file = create_exit12_meme([break_string($results['text_one'], 25),
                            break_string($results['text_two'], 25), break_string($results['text_three'], 25)], $sender);
                        send_result_photo($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_18':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['texts'] != null) {
                        $output_file = create_photo_meme(break_string($results['texts'], 40), $sender, "memes/18-facepalm/facepalm.png");
                        send_result_photo($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_19':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['text_one'] != null && $results['text_two'] != null) {
                        $output_file = create_hide_the_pain_meme([break_string($results['text_one'], 25),
                        break_string($results['text_two'], 25)], $sender);
                        send_result_photo($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_20':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['texts'] != null) {
                        $output_file = create_photo_meme(break_string($results['texts'], 40), $sender, "memes/20-spiderman/spiderman.png");
                        send_result_photo($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_21':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['texts'] != null) {
                        $output_file = create_photo_meme(break_string($results['texts'], 40), $sender, "memes/21-think-bruh/think-bruh.png");
                        send_result_photo($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_22':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/22-if-i-speak-im-in-big-trouble/22-if-i-speak-im-in-big-trouble.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 40), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_23':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/23-crying-dog/crying-dog.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 40), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_24':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/24-cat-hitting-another-cat/cat-fight.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 40), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_25':
                $results = $pdo->query("SELECT * FROM `senders` WHERE user_id=$sender")->fetchAll()[0];
                if ($results['background'] != null && $results['texts'] != null) {
                        create_input_video($sender, $results['background'], "memes/25-somebody-had-to-do-it/trump.mov");
                        $output_file = add_texts_type2(break_string($results['texts'], 40), $sender);
                        send_result_video($sender, $output_file);
                        $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0, `background` = NULL,' .
                            '`texts` = NULL WHERE `user_id` = :si;');
                        $stmt->execute(array(':si' => $sender));
                } else {
                    send("sendMessage", "chat_id=$sender&text=لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            //two kitties talking meme
            case 'settext1_tkt':
                send("sendMessage", "chat_id=$sender&text=متن اول را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text1tkt\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext2_tkt':
                send("sendMessage", "chat_id=$sender&text=متن دوم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2tkt\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext3_tkt':
                send("sendMessage", "chat_id=$sender&text=متن سوم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text3tkt\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext4_tkt':
                send("sendMessage", "chat_id=$sender&text=متن چهارم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text4tkt\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext5_tkt':
                send("sendMessage", "chat_id=$sender&text=متن پنجم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text5tkt\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;
            
            //distracted boyfriend meme
            case 'settext1_dbf':
                send("sendMessage", "chat_id=$sender&text=متن اول را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text1dbf\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext2_dbf':
                send("sendMessage", "chat_id=$sender&text=متن دوم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2dbf\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext3_dbf':
                send("sendMessage", "chat_id=$sender&text=متن سوم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text3dbf\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;
            
            //drakepost meme
            case 'settext1_dp':
                send("sendMessage", "chat_id=$sender&text=متن اول را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text1dp\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext2_dp':
                send("sendMessage", "chat_id=$sender&text=متن دوم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2dp\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            //exit 12 meme
            case 'settext1_e12':
                send("sendMessage", "chat_id=$sender&text=متن اول را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text1e12\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext2_e12':
                send("sendMessage", "chat_id=$sender&text=متن دوم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2e12\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext3_e12':
                send("sendMessage", "chat_id=$sender&text=متن سوم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text3e12\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            //hide the pain meme
            case 'settext1_hdp':
                send("sendMessage", "chat_id=$sender&text=متن اول را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text1hdp\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;

            case 'settext2_hdp':
                send("sendMessage", "chat_id=$sender&text=متن دوم را بنویسید");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = \'text2hdp\' WHERE `user_id` = :si;');
                $stmt->execute(array(':si' => $sender));
                break;
            default:
                # code...
                break;
        }
    } elseif(isset($update->message->video)) {
        //on video sent
        if ($update->message->video->file_size > 5000000) {
            send("sendMessage", "chat_id=$sender&text=لطفا کلیپی با حجم کمتر از ۵ مگابایت ارسال کنید");
        } else {
            echo "video sent\n";
            $file_id = $update->message->video->file_id;
            send("getFile", "file_id=$file_id");
            $file_path = json_decode(send("getFile", "file_id=$file_id"))->result->file_path;
            if(download_file($sender, $file_path) == False) {
                send("sendMessage", "chat_id=$sender&text=تنظیم ویدیوی پس‌زمینه موفقیت آمیز نبود، دوباره امتحان کنید");
            } else {
                send("sendMessage", "chat_id=$sender&text=ویدیوی پس‌زمینه تنظیم شد.");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0 WHERE `user_id` = :si; ');
                $stmt->execute(array(':si' => $sender));
            }
        }
    } elseif(isset($update->message->photo)) {
        //on photo sent
        if(end($update->message->photo)->file_size > 5000000) {
            send("sendMessage", "chat_id=$sender&text=لطفا عکسی با حجم کمتر از ۵ مگابایت ارسال کنید");
        } else {
            echo "photo sent\n";
            $file_id = end($update->message->photo)->file_id;
            $file_path = json_decode(send("getFile", "file_id=$file_id"))->result->file_path;
            if(download_file($sender, $file_path) == False) {
                send("sendMessage", "chat_id=$sender&text=تنظیم تصویر پس‌زمینه موفقیت آمیز نبود، دوباره امتحان کنید");
            } else {
                send("sendMessage", "chat_id=$sender&text=تصویر پس‌زمینه تنظیم شد.");
                $stmt = $pdo->prepare('UPDATE `senders` SET `checkpoint` = 0 WHERE `user_id` = :si; ');
                $stmt->execute(array(':si' => $sender));
            }
        }
    }
    //update 'last_update_id' table
    $stmt = $pdo->query('DELETE FROM `last_update_id`;');
    $stmt = $pdo->prepare('INSERT INTO `last_update_id` (`id`, `update_id`) VALUES (NULL, :uu);');
    $stmt->execute(array(':uu' => $last_update_id));
    }
}
}