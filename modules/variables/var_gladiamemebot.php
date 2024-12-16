<?php
    $NEW_MEMBER_MESSAGE = "Welcome to Gladiameme!\n\nTo start using the bot,".
        "please first join our channel:\n@$ASSOCIATED_CHANNEL\n\nCreated with love by @$ADMIN_USER_NAME ❤️";
    $MEME_CREATED_MESSAGE = "Your meme was successfuly created!\n\nEnjoy sharing it with your friends\n\nCreated By @Gladiamemebot";
    $MEME_MENU_MESSAGE = "Please fill all the fields below and then click on".
    " \"Create meme\" button:";

    //Assign, or reassign common variables
    function assign_common_variables() {
        global $user;
        global $user_id;
        global $user_record;

        //Retrieve user chat sessions
        $user_record = $user->read("telegram_user_id", $user_id)[0];
    }