<?php

if(end($update->message->photo)->file_size > 5000000) {
    dm("لطفا عکسی با حجم کمتر از ۵ مگابایت ارسال کنید");
} else {
    $background = $user_record['background'] ?? false;
    if($background && file_exists($background)) {
        unlink($background);
    }

    $file_id = end($update->message->photo)->file_id;
    $result = $telegram->getFile($file_id);
    $file_path = json_decode($result)->result->file_path;

    $file_name = $telegram->download($user_id, $file_path);
    if(!$file_name) {
        dm("تنظیم تصویر پس‌زمینه موفقیت آمیز نبود، دوباره امتحان کنید");
    } else {
        dm("تصویر پس‌زمینه تنظیم شد، لطفا سایر موارد لازم برای ساخت میم را تکمیل کنید\nدر صورت کامل بودن تمام موارد روی «ساخت میم» کلیک کنید");
        setCheckpoint("background");
        userUpdate("background", $file_name);
    }
}