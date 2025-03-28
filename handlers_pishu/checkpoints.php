<?php
switch ($checkpoint) {
    case 'background':
        $message = "لطفا تصویر یا ویدیوی مورد نظر خود را ارسال کنید";
        break;
    
    case 'text_1':
        setCheckpoint(NULL);
        userUpdate('text_one', $text);
        $message = "متن اعمال شد، جهت ساخت میم روی دکمه ساخت کلیک کنید";
        break;
    
    case 'text1tkt':
        setCheckpoint('text2tkt');
        userUpdate('text_one', $text);
        $message = "متن اول اعمال شد، متن دوم را بنویسید";
        break;
    
    case 'text2tkt':
        setCheckpoint('text3tkt');
        userUpdate('text_two', $text);
        $message = "متن دوم اعمال شد، متن سوم را بنویسید";
        break;

    case 'text3tkt':
        setCheckpoint('text4tkt');
        userUpdate('text_three', $text);
        $message = "متن سوم اعمال شد، متن چهارم را بنویسید";
        break;
    
    case 'text4tkt':
        setCheckpoint('text5tkt');
        userUpdate('text_four', $text);
        $message = "متن چهارم اعمال شد، متن پنجم را بنویسید";
        break;
    
    case 'text5tkt':
        setCheckpoint(NULL);
        userUpdate('text_five', $text);
        $message = "متن پنجم اعمال شد";
        break;

    case 'text1dbf':
        setCheckpoint('text2dbf');
        userUpdate('text_one', $text);
        $message = "متن اول اعمال شد، متن دوم را بنویسید";
        break;
    
    case 'text2dbf':
        setCheckpoint('text3dbf');
        userUpdate('text_two', $text);
        $message = "متن دوم اعمال شد، متن سوم را بنویسید";
        break;

    case 'text3dbf':
        setCheckpoint(NULL);
        userUpdate('text_three', $text);
        $message = "متن سوم اعمال شد";
        break;

    case 'text1dp':
        setCheckpoint('text2dp');
        userUpdate('text_one', $text);
        $message = "متن اول اعمال شد، متن دوم را بنویسید";
        break;
    
    case 'text2dp':
        setCheckpoint(NULL);
        userUpdate('text_two', $text);
        $message = "متن دوم اعمال شد";
        break;

    case 'text1e12':
        setCheckpoint('text2e12');
        userUpdate('text_one', $text);
        $message = "متن اول اعمال شد، متن دوم را بنویسید";
        break;
    
    case 'text2e12':
        setCheckpoint('text3e12');
        userUpdate('text_two', $text);
        $message = "متن دوم اعمال شد، متن سوم را بنویسید";
        break;
    
    case 'text3e12':
        setCheckpoint(NULL);
        userUpdate('text_three', $text);
        $message = "متن سوم اعمال شد";
        break;

    case 'text1hdp':
        setCheckpoint('text2hdp');
        userUpdate('text_one', $text);
        $message = "متن اول اعمال شد، متن دوم را بنویسید";
        break;
    
    case 'text2hdp':
        setCheckpoint(NULL);
        userUpdate('text_two', $text);
        $message = "متن دوم اعمال شد";
        break;
}

dm($message);