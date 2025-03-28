<?php

if ($update->message->video->file_size > 5000000) {
    dm("Please send a video with a maximum volume of 5 megabytes");
} else {
    $background = $user_record['background'] ?? false;
    if($background && file_exists($background)) {
        unlink($background);
    }

    $file_id = $update->message->video->file_id;
    $result = $telegram->getFile($file_id);
    $file_path = json_decode($result)->result->file_path;

    $file_name = $telegram->download($user_id, $file_path);
    if(!$file_name) {
        dm("Setting background video failed, try again...");
    } else {
        dm("Background video set...");
        setCheckpoint("Background");
        userUpdate("background", $file_name);
    }
}