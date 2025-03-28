<?php

if ($update->message->video->file_size > 5000000) {
    dm("لطفا کلیپی با حجم کمتر از ۵ مگابایت ارسال کنید");
} else {
    $background = $user_record['background'];
    if($background && file_exists($background)) {
        unlink($background);
    }

    $file_id = $update->message->video->file_id;
    $result = $telegram->getFile($file_id);
    $file_path = json_decode($result)->result->file_path;

    $file_name = $telegram->download($user_id, $file_path);
    if(!$file_name) {
        dm("تنظیم ویدیوی پس‌زمینه موفقیت آمیز نبود، دوباره امتحان کنید");
    } else {
        dm("ویدیوی پس‌زمینه تنظیم شد");
        setCheckpoint("background");
        userUpdate("background", $file_name);
    }
}