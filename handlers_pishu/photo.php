<?php
//on photo sent
if(end($update->message->photo)->file_size > 5000000) {
    $telegram->sendMessage($user_id, "لطفا عکسی با حجم کمتر از ۵ مگابایت ارسال کنید");
} else {

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