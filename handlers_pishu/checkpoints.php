<?php

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
}