<?php
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