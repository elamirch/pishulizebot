<?php

function setCheckpoint($text) {
    global $user, $user_id;
    $user->update('telegram_user_id', $user_id, 'checkpoint', $text);
}

function logMessage($message) {
    $logFile = "/tmp/gladiameme-logs.log";
    $formattedMessage = "[" . date("Y-m-d H:i:s") . "] " . print_r($message, true) . "\n";
    file_put_contents($logFile, $formattedMessage, FILE_APPEND);
}

function userUpdate($updateColumn, $updateValue) {
    global $user, $user_id;
    $user->update('telegram_user_id', $user_id, $updateColumn, $updateValue);
}

function dm($message) {
    global $telegram, $user_id;
    $telegram->sendMessage($user_id, $message);
}

function validateOrDmError(array $inputs): bool {
    global $user_record;

    logMessage("Validating Array: " . json_encode($inputs));
    foreach ($inputs as $input) {
        logMessage("Validating Input: " . $input);
        if(is_null($user_record[$input])) {
            dm(
                "Creating meme failed❗️\nPlease fill all the necessary".
                "fields again and click on \"Create meme\" button"
            );
            return false;
        }
    }

    return true;
}

function createInputVideo($videoPath) {
    global $memes, $user_id, $user_record;
    $memes->create_input_video($user_id, $user_record['background'], $videoPath);
}

function sendVideoMeme($fileToSend) {
    global $telegram, $user_id, $MEME_CREATED_MESSAGE;
    $telegram->sendVideo($user_id, $fileToSend, $MEME_CREATED_MESSAGE);
}

function sendPhotoMeme($fileToSend) {
    global $telegram, $user_id, $MEME_CREATED_MESSAGE;
    $telegram->sendPhoto($user_id, $fileToSend, $MEME_CREATED_MESSAGE);
}

function createMeme($memeId, $texts) {
    global $memes, $user_id;
    return $memes->create($memeId, $texts, $user_id);
}