<?php
require_once("./modules/bootstrap/bs_gladiamemebot.php");
require_once("./modules/bootstrap/bs_common.php");
require_once("./modules/variables/var_gladiamemebot.php");


$update = json_decode(file_get_contents('php://input'));
$user_id = $update->message->from->id ?? $update->callback_query->from->id ?? false;
logMessage('Update from: ' . $user_id);

$user_record = $user->read("telegram_user_id", $user_id);

//user_info variable is derived from our channel, as a result it has
//more information than the user object in $update object such as a 
//first name (which is exactly what we'll use for usage monitoring)
$user_info = json_decode($telegram->getChatMember($user_id))->result ?? false;

//Handling new user joins
require_once("handlers/newUser.php");

//Ask the user to join the bot's channel if not yet joined
if ($user_info->status == "left") {
    dm($NEW_MEMBER_MESSAGE);
}

//If the user sent a text (and not a callback_query)
elseif(isset($update->message->text)) {
    $text = $update->message->text;

    require_once("handlers/menuAndCommands.php");
    
    //Retrieve user_record again as it may have been flushed
    $user_record = $user->read("telegram_user_id", $user_id);
    $checkpoint = $user_record['checkpoint'] ?? false;

    //Set meme texts based on checkpoints
    if($checkpoint) {
        require_once("handlers/checkpoints.php");
    }
}

//If the user sent a callback_query
elseif(isset($update->callback_query)) {
    require_once("handlers/callbackQuery.php");
}

//If the user sent a video
elseif(isset($update->message->video)) {
    require_once("handlers/video.php");
}

//If the user sent a photo
elseif(isset($update->message->photo)) {
    require_once("handlers/photo.php");
}