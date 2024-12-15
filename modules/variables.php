<?php
    $NEW_MEMBER_MESSAGE = "برای استفاده از بات لطفا در کانال پیشولیزه عضو شوید و دوباره دکمه استارت را بزنید:\n@$ASSOCIATED_CHANNEL";
    $START_MESSAGE = "Bot started, send any message to initiate a conversation!\n\n" .
    "\n\nAnytime you needed more help on how to make the best use of the bot, use the".
    "main menu\n\nCreated with love by @$ADMIN_USER_NAME ❤️";
    
    //Assign, or reassign common variables
    function assign_common_variables() {
        global $user;
        global $user_id;
        global $user_record;

        //Retrieve user chat sessions
        $user_record = $user->read("telegram_user_id", $user_id)[0];
    }