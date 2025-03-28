<?php

if(end($update->message->photo)->file_size > 5000000) {
    dm("Please send a photo with a maximum volume of 5 megabytes");
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
        dm("Setting background photo failed, try again...");
    } else {
        dm("Background photo set...");
        setCheckpoint("Background");
        userUpdate("background", $file_name);
    }
}