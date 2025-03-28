<?php

switch($text) {
    case '/start':
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
}