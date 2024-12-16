<?php
require_once("./modules/bootstrap/bs_gladiamemebot.php");
require_once("./modules/bootstrap/bs_common.php");
require_once("./modules/variables/var_gladiamemebot.php");

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
                    $telegram->sendMessage($user_id, "Send a background photo or video...");
                    break;
                
                case 'text_1':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);

                    $telegram->sendMessage($user_id, "Text was set, click on \"Create meme\" to create the meme");
                    break;
                
                case 'text1tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2tkt');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);

                    $telegram->sendMessage($user_id, "First text was set, now write the second text...");
                    break;
                
                case 'text2tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text3tkt');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);

                    $telegram->sendMessage($user_id, "Second text was set, now write the third text...");
                    break;

                case 'text3tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text4tkt');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_three', $text);
                    
                    $telegram->sendMessage($user_id, "Third text was set, now write the fourth text...");
                    break;
                
                case 'text4tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text5tkt');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_four', $text);
                    
                    $telegram->sendMessage($user_id, "Fourth text was set, now write the fifth text...");
                    break;
                
                case 'text5tkt':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_five', $text);
                    
                    $telegram->sendMessage($user_id, "Fifth text was set, if you're finished with all the texts,".
                        " click on the \"Create meme\" button");
                    break;

                case 'text1dbf':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2dbf');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);
                    
                    $telegram->sendMessage($user_id, "First text set, now write the second text...");
                    break;
                
                case 'text2dbf':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text3dbf');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);
                    
                    $telegram->sendMessage($user_id, "Second text set, now write the third text...");
                    break;

                case 'text3dbf':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_three', $text);
                    
                    $telegram->sendMessage($user_id, "Third text was set, if you're finished with all the texts,".
                        " click on the \"Create meme\" button");
                    break;

                case 'text1dp':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2dp');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);
                    
                    $telegram->sendMessage($user_id, "First text was set, now write the second text...");
                    break;
                
                case 'text2dp':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);
                    
                    $telegram->sendMessage($user_id, "Second text was set, if you're finished with all the texts,".
                            " click on the \"Create meme\" button");
                    break;

                case 'text1e12':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2e12');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);
                    
                    $telegram->sendMessage($user_id, "First text was set, now write the second text...");
                    break;
                
                case 'text2e12':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text3e12');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);
                    
                    $telegram->sendMessage($user_id, "Second text was set, now write the third text...");
                    break;
                
                case 'text3e12':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_three', $text);
                    
                    $telegram->sendMessage($user_id, "Third text was set, if you're finished with all the texts,".
                            " click on the \"Create meme\" button");
                    break;

                case 'text1hdp':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', 'text2hdp');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_one', $text);
                    
                    $telegram->sendMessage($user_id, "First text was set, now write the second text...");
                    break;
                
                case 'text2hdp':
                    $user->update('telegram_user_id', $user_id, 'checkpoint', '');

                    $text = $update->message->text;

                    $user->update('telegram_user_id', $user_id, 'text_two', $text);
                    
                    $telegram->sendMessage($user_id, "Second text was set, if you're finished with all the texts,".
                            " click on the \"Create meme\" button");
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
                    var_dump($telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/0-start-menu.jpg",
                        "Select one of the above memes from the menu:", $meme_selector_markup_encoded));
                    break;
                case '1- Talking Cats 😺😿':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/1.mp4",
                        $MEME_MENU_MESSAGE, $tkt_meme_setting_markup_encoded);
                    break;
                case '2- Brother Eww! 👳🏽':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/2.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_2_encoded);
                    break;
                case '3- The Rock\'s Eyebrow 🤨':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/3.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_3_encoded);
                    break;
                case '4- Nicolas Cage & Pedro Pascal 😕🤪':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/4.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_4_encoded);
                    break;
                case '5- John Cena Shocked 😱':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/5.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_5_encoded);
                    break;
                case '6- Juan\'s Laughter 🤣':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/6.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_6_encoded);
                    break;
                case '7- Driver Cat 😽🚖':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/7.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_7_encoded);
                    break;
                case '8- Mr. Fresh\'s Cat 😼':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/8.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_8_encoded);
                    break;
                case '9- Goat & Kitty 🐐🐈‍⬛':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/9.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_9_encoded);
                    break;
                case '10- Sleepy Kitty 😿':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/10.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_10_encoded);
                    break;
                case '11- Chewing Donkey 🐴':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/11.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_11_encoded);
                    break;
                case '12- Hasbulla Counting Money 💵':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/12.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_12_encoded);
                    break;
                case '13- Disaster Girl 😏':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/13.jpg",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_13_encoded);
                    break;
                case '14- Distracted Boyfriend 🤤':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/14.jpg",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_14_encoded);
                    break;
                case '15- Kermit\'s Evil Advices 😈':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/15.jpg",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_15_encoded);
                    break;
                case '16- Drakepost 🤚🏾👉🏾':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/16.jpg",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_16_encoded);
                    break;
                case '17- Exit 12 ⬆️↗️':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/17.jpg",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_17_encoded);
                    break;
                case '18- Facepalm 😑':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/18.jpg",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_18_encoded);
                    break;
                case '19- Hide The Pain Harold 😅':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/19.jpg",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_19_encoded);
                    break;
                case '20- Spidermans 🕸':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/20.jpg",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_20_encoded);
                    break;
                case '21- Think Bro! 😎':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendPhoto($user_id, "./samples/sm_gladiamemebot/21.jpg",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_21_encoded);
                    break;
                case "22- Mourinho: If I speak I'm in big trouble":
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/22.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_22_encoded);
                    break;
                case '23- Crying Dog 😭':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/23.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_23_encoded);
                    break;
                case '24- Cat Fight 😾🔥':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/24.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_24_encoded);
                    break;
                case '25- Trump: Somebody had to do it':
                    $user->flush($user_id);
                    $memes->empty_files_dir($user_id);
                    $telegram->sendVideo($user_id, "./samples/sm_gladiamemebot/25.mp4",
                        $MEME_MENU_MESSAGE, $meme_setting_markup_25_encoded);
                    break;
                default:
                    //no need for a text
                    break;
            }
    } elseif(isset($update->callback_query)) {
        switch ($update->callback_query->data) {
            case 'setbackground':
                $telegram->sendMessage($user_id, "Send a background photo or video...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "background");
                break;
            
            case 'settext':
                $telegram->sendMessage($user_id, "Write the text you want on the meme...");
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
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_2':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                    $memes->create_input_video($user_id, $results['background'], "memes/2-brother-eww/2-brother-eww.mov");

                    $output_file = $memes->create('2', break_string($results['text_one'], 28), $user_id);

                    $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;

            case 'create_3':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/3-the-rock-sus/3-the-rock-sus.mov");

                        $output_file = $memes->create('3', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_4':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/4-cage-and-pascal/4-cage-and-pascal.mov");
                        
                        $output_file = $memes->create('4', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_5':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/5-shocked-john-cena/5-shocked-john-cena.mov");
                        
                        $output_file = $memes->create('5', break_string($results['text_one'], 30), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;

            case 'create_6':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/6-juan-laughing/6-juan-laughing.mov");
                        
                        $output_file = $memes->create('6', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_7':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/7-driving-cat/7-driving-cat.mov");
                        
                        $output_file = $memes->create('7', break_string($results['text_one'], 30), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_8':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/8-mr-fresh-cat/8-mr-fresh-cat.mov");
                        
                        $output_file = $memes->create('8', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;

            case 'create_9':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/9-goat-and-clueless-cat/9-goat-n-kitty.mov");
                        
                        $output_file = $memes->create('9', break_string($results['text_one'], 30), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_10':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/10-kitty-saying-arreh/10-kitty-saying-arreh.mov");
                        
                        $output_file = $memes->create('10', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_11':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/11-donkey-eating/11-donkey-eating.mov");
                        
                        $output_file = $memes->create('11', break_string($results['text_one'], 30), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;

            case 'create_12':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['background'] != null && $results['text_one'] != null) {
                        $memes->create_input_video($user_id, $results['background'], "memes/12-hasbulla-counting-money/12-hasbulla-counting-money.mov");
                        
                        $output_file = $memes->create('12', break_string($results['text_one'], 28), $user_id);
                        
                        $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_13':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                        $output_file = $memes->create('13', break_string($results['text_one'], 40), $user_id);

                        $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_14':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null && $results['text_two'] != null && $results['text_three'] != null) {
                        $output_file = $memes->create('14', [break_string($results['text_one'], 8),
                                break_string($results['text_two'], 12),
                                break_string($results['text_three'], 11)], $user_id);
                        
                        $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;

            case 'create_15':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                    $output_file = $memes->create('15', break_string($results['text_one'], 40), $user_id);
                    
                    $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;

            case 'create_16':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null && $results['text_two'] != null) {
                        $output_file = $memes->create('16', [break_string($results['text_one'], 22),
                            break_string($results['text_two'], 22)], $user_id);

                        $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
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
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_18':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                        $output_file = $memes->create('18', break_string($results['text_one'],
                            40), $user_id);
                        
                        $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;

            case 'create_19':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null && $results['text_two'] != null) {
                    $output_file = $memes->create('19', [break_string($results['text_one'],
                            25), break_string($results['text_two'], 25)], $user_id);

                    $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_20':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                    $output_file = $memes->create('20', break_string($results['text_one'],
                            40), $user_id);
                    
                    $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            case 'create_21':
                $results = $user->read("telegram_user_id", $user_id);
                if ($results['text_one'] != null) {
                    
                    $output_file = $memes->create('21', break_string($results['text_one'],
                            40), $user_id);
                    
                    $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
                } else {
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
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
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
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
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
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
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
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
                    $telegram->sendMessage($user_id, "Please fill all the necessary fields...");
                }
                break;
            
            //two kitties talking meme
            case 'settext1_tkt':
                $telegram->sendMessage($user_id, "Write the first text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1tkt");
                break;

            case 'settext2_tkt':
                $telegram->sendMessage($user_id, "Write the second text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text2tkt");
                break;

            case 'settext3_tkt':
                $telegram->sendMessage($user_id, "Write the third text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text3tkt");
                break;

            case 'settext4_tkt':
                $telegram->sendMessage($user_id, "Write the fourth text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text4tkt");
                break;

            case 'settext5_tkt':
                $telegram->sendMessage($user_id, "Write the fifth text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text5tkt");
                break;
            
            //distracted boyfriend meme
            case 'settext1_dbf':
                $telegram->sendMessage($user_id, "Write the first text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1dbf");
                break;

            case 'settext2_dbf':
                $telegram->sendMessage($user_id, "Write the second text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text2dbf");
                break;

            case 'settext3_dbf':
                $telegram->sendMessage($user_id, "Write the third text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text3dbf");
                break;
            
            //drakepost meme
            case 'settext1_dp':
                $telegram->sendMessage($user_id, "Write the first text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1dp");
                break;

            case 'settext2_dp':
                $telegram->sendMessage($user_id, "Write the second text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text2dp");
                break;

            //exit 12 meme
            case 'settext1_e12':
                $telegram->sendMessage($user_id, "Write the first text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1e12");
                break;

            case 'settext2_e12':
                $telegram->sendMessage($user_id, "Write the second text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text2e12");
                break;

            case 'settext3_e12':
                $telegram->sendMessage($user_id, "Write the third text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text3e12");
                break;

            //hide the pain meme
            case 'settext1_hdp':
                $telegram->sendMessage($user_id, "Write the first text...");
                $user->update("telegram_user_id", $user_id, "checkpoint", "text1hdp");
                break;

            case 'settext2_hdp':
                $telegram->sendMessage($user_id, "Write the second text...");
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
            $telegram->sendMessage($user_id, "Please send a video with a maximum volume of 5 megabytes");
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
                $telegram->sendMessage($user_id, "Setting background video failed, try again...");
            } else {
                $telegram->sendMessage($user_id, "Background video set...");
                $user->update("checkpoint", "", "telegram_user_id", $user_id);
            }
        }
    } elseif(isset($update->message->photo)) {
        //on photo sent
        if(end($update->message->photo)->file_size > 5000000) {
            $telegram->sendMessage($user_id, "Please send a photo with a maximum volume of 5 megabytes");
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
                $telegram->sendMessage($user_id, "Setting background photo failed, try again...");
            } else {
                $telegram->sendMessage($user_id, "Background photo set...");
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