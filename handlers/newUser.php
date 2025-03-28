<?php
if (!$user_record) {
    //If the user has no Telegram username, set it to not_set in database
    $username = $user_info->user->username ?? 'not_set';
    $user->create($user_id);
    if(!is_dir("files/$user_id")) {
        mkdir("files/$user_id", 0755, true);
    }
}