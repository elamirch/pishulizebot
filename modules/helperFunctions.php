<?php

function setCheckpoint($checkpoint) {
    global $user, $user_id;
    $user->update('telegram_user_id', $user_id, 'checkpoint', $checkpoint);
}

function logMessage($message) {
    global $logFile;
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
    global $user_record, $MEME_CREATION_FAILURE_ERROR;

    logMessage("Validating Array: " . json_encode($inputs));
    foreach ($inputs as $input) {
        logMessage("Validating Input: " . $input);
        if(is_null($user_record[$input])) {
            dm($MEME_CREATION_FAILURE_ERROR);
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

//this function breaks strings by the given chunk size so that the 
//text written to the output video will stay within the video's resolution
function break_string($string, $chunk_size) {
    $lines = array();
    $lines[0] = '';
    $string = str_replace("'", '`', $string);
    $words = mb_split(" ", $string);
    $i = 0;
    foreach($words as $key=>$word) {
        if(mb_strlen($lines[$i]) + mb_strlen($word) < $chunk_size) {
            $lines[$i] = $lines[$i] . $word . " ";
        } else {
            $i++;
            $lines[$i] = $word . ' ';
        }
    }
    return $lines;
}