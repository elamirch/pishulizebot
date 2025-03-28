<?php
switch($update->message->text) {
    case '/start':
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
}