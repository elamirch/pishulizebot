<?php
require_once("./modules/bootstrap/bs_pishulizebot.php");
require_once("./modules/bootstrap/bs_common.php");
require_once("./modules/variables/var_pishulizebot.php");

//this function breaks strings by the given chunk size so that the 
//text written to the output video will stay within the video's resolution
function break_string($string, $chunk_size) {
    $lines = array();
    $lines[0] = '';
    $string = str_replace("'", '`', $string);
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

//Just a number close to the current time's last update id
$last_update_id = 380000000;

while(true) {
sleep(1);

//if there are new updates, do the job, if there are none, don't update 'last_update_id' table
$updates = json_decode($telegram->getUpdates($last_update_id))->result ?? False;
echo "Last update id: " . $last_update_id . "\n";
if($updates) {
foreach($updates as $update) {
    var_dump($update);

    $last_update_id = $update->update_id;
    $user_id = $update->message->from->id ?? $update->callback_query->from->id ?? false;
    
    if(!$user_id) {//Bot will only expect messages (or media) or callback queries
        var_dump($update);
        continue;
    }
    
    $user_record = $user->read("telegram_user_id", $user_id);

    //user_info variable is derived from our channel, as a result it has
    //more information than the user object in $update object such as a 
    //first name (which is exactly what we'll use for usage monitoring
    $user_info = json_decode($telegram->getChatMember($user_id))->result ?? false;

    if (!$user_record) {//Check if user exists in database
        //When a new user joins
        //If the user has no Telegram username, set it to NOT.SET in database
        $username = $user_info->user->username ?? 'N/A';
        $user->create($user_id);
        if(!is_dir("files/$user_id")) {
            mkdir("files/$user_id", 0755, true);
        }

    }
    echo "\nStatus: $user_info->status\n";
    if ($user_info->status == "left") {//Ask the user to join the bot's channel if not yet joined
        $telegram->sendMessage($user_id, $NEW_MEMBER_MESSAGE);
    } elseif(isset($update->message->text)) {//If the user sent a text (and not a callback_query)
            $user_record = $user->read("telegram_user_id", $user_id);
            $checkpoint = $user_record['checkpoint'] ?? false;

            switch ($checkpoint) {
                case 'background':
                    echo $user_id . "\n";
                    $telegram->sendMessage($user_id, "لطفا تصویر یا ویدیوی مورد نظر خود را ارسال کنید");
                    break;
                
                case 'text_1':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);

                    $telegram->sendMessage($user_id, "متن اعمال شد، جهت ساخت میم روی دکمه ساخت کلیک کنید");
                    break;
                
                case 'text1tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2tkt');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);

                    $telegram->sendMessage($user_id, "متن اول اعمال شد، متن دوم را بنویسید");
                    break;
                
                case 'text2tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text3tkt');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);

                    $telegram->sendMessage($user_id, "متن دوم اعمال شد، متن سوم را بنویسید");
                    break;

                case 'text3tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text4tkt');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_three', $text);
                    
                    $telegram->sendMessage($user_id, "متن سوم اعمال شد، متن چهارم را بنویسید");
                    break;
                
                case 'text4tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text5tkt');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_four', $text);
                    
                    $telegram->sendMessage($user_id, "متن چهارم اعمال شد، متن پنجم را بنویسید");
                    break;
                
                case 'text5tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_five', $text);
                    
                    $telegram->sendMessage($user_id, "متن پنجم اعمال شد");
                    break;

                case 'text1dbf':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2dbf');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);
                    
                    $telegram->sendMessage($user_id, "متن اول اعمال شد، متن دوم را بنویسید");
                    break;
                
                case 'text2dbf':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text3dbf');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);
                    
                    $telegram->sendMessage($user_id, "متن دوم اعمال شد، متن سوم را بنویسید");
                    break;

                case 'text3dbf':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_three', $text);
                    
                    $telegram->sendMessage($user_id, "متن سوم اعمال شد");
                    break;

                case 'text1dp':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2dp');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);
                    
                    $telegram->sendMessage($user_id, "متن اول اعمال شد، متن دوم را بنویسید");
                    break;
                
                case 'text2dp':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);
                    
                    $telegram->sendMessage($user_id, "متن دوم اعمال شد");
                    break;

                case 'text1e12':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2e12');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);
                    
                    $telegram->sendMessage($user_id, "متن اول اعمال شد، متن دوم را بنویسید");
                    break;
                
                case 'text2e12':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text3e12');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);
                    
                    $telegram->sendMessage($user_id, "متن دوم اعمال شد، متن سوم را بنویسید");
                    break;
                
                case 'text3e12':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_three', $text);
                    
                    $telegram->sendMessage($user_id, "متن سوم اعمال شد");
                    break;

                case 'text1hdp':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2hdp');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);
                    
                    $telegram->sendMessage($user_id, "متن اول اعمال شد، متن دوم را بنویسید");
                    break;
                
                case 'text2hdp':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);
                    
                    $telegram->sendMessage($user_id, "متن دوم اعمال شد");
                    break;
                default:
                    # code...
                    break;
            }
            switch($update->message->text) {
                case '/start':// on /start command
                    echo "\nStarted\n";
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    var_dump($telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/0-start-menu.jpg",
                        "لطفا یکی از میم‌های بالا را از منو انتخاب کنید:", $meme_selector_markup_encoded));
                    break;
                case '۱- دو تا پیشی در حال صحبت':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/1.mp4", $MEME_MENU_MESSAGE, $tkt_meme_setting_markup_encoded);
                    break;
                case '۲- Brother Eww!':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/2.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_2_encoded);
                    break;
                case '۳- سیس گرفتن راک':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/3.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_3_encoded);
                    break;
                case '۴- نیکولاس کیج و پدرو پاسکال':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/4.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_4_encoded);
                    break;
                case '۵- شوکه شدن جان سینا':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/5.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_5_encoded);
                    break;
                case '۶- خنده خوان':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/6.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_6_encoded);
                    break;
                case '۷- گربه در حال رانندگی':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/7.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_7_encoded);
                    break;
                case '۸- گربه Mr. Fresh':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/8.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_8_encoded);
                    break;
                case '۹- گفتگوی پیشی و بز':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/9.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_9_encoded);
                    break;
                case '۱۰- پیشی در حال آره گفتن':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/10.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_10_encoded);
                    break;
                case '۱۱- جویدن خر':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/11.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_11_encoded);
                    break;
                case '۱۲- حسب‌الله در حال شمردن پول':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/12.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_12_encoded);
                    break;
                case '۱۳- Disaster Girl':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/13.jpg", $MEME_MENU_MESSAGE, $meme_setting_markup_13_encoded);
                    break;
                case '۱۴- دوست پسر چشم چرون':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/14.jpg", $MEME_MENU_MESSAGE, $meme_setting_markup_14_encoded);
                    break;
                case '۱۵- کرمیت در حال مشاوره شیطانی':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/15.jpg", $MEME_MENU_MESSAGE, $meme_setting_markup_15_encoded);
                    break;
                case '۱۶- Drakepost':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/16.jpg", $MEME_MENU_MESSAGE, $meme_setting_markup_16_encoded);
                    break;
                case '۱۷- خروجی ۱۲':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/17.jpg", $MEME_MENU_MESSAGE, $meme_setting_markup_17_encoded);
                    break;
                case '۱۸- Facepalm':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/18.jpg", $MEME_MENU_MESSAGE, $meme_setting_markup_18_encoded);
                    break;
                case '۱۹- هارولد در حال مخفی کردن درد':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/19.jpg", $MEME_MENU_MESSAGE, $meme_setting_markup_19_encoded);
                    break;
                case '۲۰- اسپایدرمن':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/20.jpg", $MEME_MENU_MESSAGE, $meme_setting_markup_20_encoded);
                    break;
                case '۲۱- ذکاوت!':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_pishulizebot/21.jpg", $MEME_MENU_MESSAGE, $meme_setting_markup_21_encoded);
                    break;
                case "۲۲- مورینیو: If I speak I'm in big trouble":
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/22.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_22_encoded);
                    break;
                case '۲۳- سگ گریان':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/23.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_23_encoded);
                    break;
                case '۲۴- دعوای پیشی‌ها':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/24.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_24_encoded);
                    break;
                case '۲۵- ترامپ: Somebody had to do it, I am the chosen one':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_pishulizebot/25.mp4", $MEME_MENU_MESSAGE, $meme_setting_markup_25_encoded);
                    break;
                default:
                    //no need for a text
                    break;
            }
    } elseif(isset($update->callback_query)) {
        switch ($update->callback_query->data) {
            case 'setbackground':
                $telegram->sendMessage($user_id, "تصویر یا ویدیوی مورد نظر خود را ارسال کنید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "background");
                break;
            
            case 'settext':
                $telegram->sendMessage($user_id, "متن مورد نظر خود را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text_1");
                break;
            
            case 'create_1':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null &&
                    $results['text_two'] != null && $results['text_three'] != null &&
                    $results['text_four'] != null && $results['text_five'] != null) {

                        $memes->create_input_video($user_id, $results['background'], "memes/1-two-kitties-talking/1-tkt.mov");
                        
                        $texts = [break_string($results['text_one'], 32),
                        break_string($results['text_two'], 14),
                        break_string($results['text_three'], 32),
                        break_string($results['text_four'], 14),
                        break_string($results['text_five'], 14)];

                        $output_file = $memes->create('1', $texts, $user_id);

                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_2':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                    $memes->create_input_video($user_id, $results['background'], "memes/2-brother-eww/2-brother-eww.mov");

                    $output_file = $memes->create('2', break_string($results['text_one'], 28), $user_id);

                    $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_3':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/3-the-rock-sus/3-the-rock-sus.mov");

                        $output_file = $memes->create('3', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_4':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/4-cage-and-pascal/4-cage-and-pascal.mov");
                        
                        $output_file = $memes->create('4', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_5':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/5-shocked-john-cena/5-shocked-john-cena.mov");
                        
                        $output_file = $memes->create('5', break_string($results['text_one'], 30), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_6':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/6-juan-laughing/6-juan-laughing.mov");
                        
                        $output_file = $memes->create('6', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_7':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/7-driving-cat/7-driving-cat.mov");
                        
                        $output_file = $memes->create('7', break_string($results['text_one'], 30), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_8':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/8-mr-fresh-cat/8-mr-fresh-cat.mov");
                        
                        $output_file = $memes->create('8', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_9':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/9-goat-and-clueless-cat/9-goat-n-kitty.mov");
                        
                        $output_file = $memes->create('9', break_string($results['text_one'], 30), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_10':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/10-kitty-saying-arreh/10-kitty-saying-arreh.mov");
                        
                        $output_file = $memes->create('10', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_11':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/11-donkey-eating/11-donkey-eating.mov");
                        
                        $output_file = $memes->create('11', break_string($results['text_one'], 30), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_12':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/12-hasbulla-counting-money/12-hasbulla-counting-money.mov");
                        
                        $output_file = $memes->create('12', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_13':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                        $output_file = $memes->create('13', break_string($results['text_one'], 40), $user_id);

                        $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_14':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null && $results['text_two'] != null && $results['text_three'] != null) {
                        $output_file = $memes->create('14', [break_string($results['text_one'], 8),
                                break_string($results['text_two'], 12),
                                break_string($results['text_three'], 10)], $user_id);
                        
                        $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_15':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                    $output_file = $memes->create('15', break_string($results['text_one'], 40), $user_id);
                    
                    $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_16':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null && $results['text_two'] != null) {
                        $output_file = $memes->create('16', [break_string($results['text_one'], 22),
                            break_string($results['text_two'], 22)], $user_id);

                        $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_17':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null && $results['text_two'] != null && $results['text_three'] != null) {
                        $output_file = $memes->create('17', [break_string($results['text_one'], 8),
                                    break_string($results['text_two'], 10),
                                    break_string($results['text_three'], 11)], $user_id);
                        
                        $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_18':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                        $output_file = $memes->create('18', break_string($results['text_one'],
                            40), $user_id);
                        
                        $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_19':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null && $results['text_two'] != null) {
                    $output_file = $memes->create('19', [break_string($results['text_one'],
                            25), break_string($results['text_two'], 25)], $user_id);

                    $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_20':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                    $output_file = $memes->create('20', break_string($results['text_one'],
                            40), $user_id);
                    
                    $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_21':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                    
                    $output_file = $memes->create('21', break_string($results['text_one'],
                            40), $user_id);
                    
                    $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_22':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                    
                    $memes->create_input_video($user_id, $results['background'], "memes/22-if-i-speak-im-in-big-trouble/22-if-i-speak-im-in-big-trouble.mov");
                    
                    $output_file = $memes->create('22', break_string($results['text_one'],
                            30), $user_id);
                    
                    $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;

            case 'create_23':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                    
                    $memes->create_input_video($user_id, $results['background'], "memes/23-crying-dog/crying-dog.mov");
                    
                    $output_file = $memes->create('23', break_string($results['text_one'],
                            30), $user_id);

                    $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_24':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                    
                    $memes->create_input_video($user_id, $results['background'], "memes/24-cat-hitting-another-cat/cat-fight.mov");

                    $output_file = $memes->create('24', break_string($results['text_one'],
                            30), $user_id);

                    $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            case 'create_25':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                    
                    $memes->create_input_video($user_id, $results['background'], "memes/25-somebody-had-to-do-it/trump.mov");
                    
                    $output_file = $memes->create('25', break_string($results['text_one'],
                            30), $user_id);

                    $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "لطفا تمام بخش‌ها را کامل کنید");
                }
                break;
            
            //two kitties talking meme
            case 'settext1_tkt':
                $telegram->sendMessage($user_id, "متن اول را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1tkt");
                break;

            case 'settext2_tkt':
                $telegram->sendMessage($user_id, "متن دوم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text2tkt");
                break;

            case 'settext3_tkt':
                $telegram->sendMessage($user_id, "متن سوم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text3tkt");
                break;

            case 'settext4_tkt':
                $telegram->sendMessage($user_id, "متن چهارم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text4tkt");
                break;

            case 'settext5_tkt':
                $telegram->sendMessage($user_id, "متن پنجم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text5tkt");
                break;
            
            //distracted boyfriend meme
            case 'settext1_dbf':
                $telegram->sendMessage($user_id, "متن اول را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1dbf");
                break;

            case 'settext2_dbf':
                $telegram->sendMessage($user_id, "متن دوم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text2dbf");
                break;

            case 'settext3_dbf':
                $telegram->sendMessage($user_id, "متن سوم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text3dbf");
                break;
            
            //drakepost meme
            case 'settext1_dp':
                $telegram->sendMessage($user_id, "متن اول را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1dp");
                break;

            case 'settext2_dp':
                $telegram->sendMessage($user_id, "متن دوم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text2dp");
                break;

            //exit 12 meme
            case 'settext1_e12':
                $telegram->sendMessage($user_id, "متن اول را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1e12");
                break;

            case 'settext2_e12':
                $telegram->sendMessage($user_id, "متن دوم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text2e12");
                break;

            case 'settext3_e12':
                $telegram->sendMessage($user_id, "متن سوم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text3e12");
                break;

            //hide the pain meme
            case 'settext1_hdp':
                $telegram->sendMessage($user_id, "متن اول را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1hdp");
                break;

            case 'settext2_hdp':
                $telegram->sendMessage($user_id, "متن دوم را بنویسید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text2hdp");
                break;

            default:
                # code...
                break;
        }
        
        if(substr($update->callback_query->data, 0, 6) == 'create') {
            $user->flush($user_id);
            if(isset($output_file) && file_exists($output_file)) {
                unlink($output_file);
            }
            if(file_exists("files/$user_id/input.mp4")) {
                unlink("files/$user_id/input.mp4");
            }
        }
    } elseif(isset($update->message->video)) {
        //on video sent
        if ($update->message->video->file_size > 5000000) {
            $telegram->sendMessage($user_id, "لطفا کلیپی با حجم کمتر از ۵ مگابایت ارسال کنید");
        } else {
            echo "Video sent\n";

            $background = $user->read("telegram_user_id", $user_id)['background'];
            if(file_exists($background)) {
                unlink($background);
            }

            $file_id = $update->message->video->file_id;
            $result = $telegram->getFile($file_id);
            $file_path = json_decode($result)->result->file_path;

            if($telegram->download($user_id, $file_path) == False) {
                $telegram->sendMessage($user_id, "تنظیم ویدیوی پس‌زمینه موفقیت آمیز نبود، دوباره امتحان کنید");
            } else {
                $telegram->sendMessage($user_id, "ویدیوی پس‌زمینه تنظیم شد");
                $user->update("checkpoint", "", "telegram_user_id", $user_id);
            }
        }
    } elseif(isset($update->message->photo)) {
        //on photo sent
        if(end($update->message->photo)->file_size > 5000000) {
            $telegram->sendMessage($user_id, "لطفا عکسی با حجم کمتر از ۵ مگابایت ارسال کنید");
        } else {
            echo "Photo sent\n";

            $background = $user->read("telegram_user_id", $user_id)['background'] ?? false;
            if($background && file_exists($background)) {
                unlink($background);
            }

            $file_id = end($update->message->photo)->file_id;
            $result = $telegram->getFile($file_id);
            $file_path = json_decode($result)->result->file_path;

            $file_name = $telegram->download($user_id, $file_path);
            if(!$file_name) {
                $telegram->sendMessage($user_id, "تنظیم تصویر پس‌زمینه موفقیت آمیز نبود، دوباره امتحان کنید");
            } else {
                $telegram->sendMessage($user_id, "تصویر پس‌زمینه تنظیم شد، لطفا سایر موارد لازم برای ساخت میم را تکمیل کنید\nدر صورت کامل بودن تمام موارد روی «ساخت میم» کلیک کنید");
                $user->update("telegram_user_id", $user_id, "checkpoint", "");
                $user->update("telegram_user_id", $user_id, "background", $file_name);
            }
        }
    }
    }

    //update 'last_update_id'
    $last_update_id += 1;
}
}