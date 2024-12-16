<?php
    $NEW_MEMBER_MESSAGE = "برای استفاده از بات لطفا در کانال پیشولیزه عضو شوید و دوباره دکمه استارت را بزنید:\n@$ASSOCIATED_CHANNEL";
    $MEME_CREATED_MESSAGE = "میم شما با موفقیت ساخته شد 🥳🤩\n\nبا همرسانی میمتون با دوستاتون می‌تونید به گسترش شادی کمک کنید 😇\n\nساخته شده با @pishulizebot";
    $MEME_MENU_MESSAGE = "لطفا پس از تنظیم تمامی موارد زیر روی «ساخت میم» کلیک کنید";
    //Assign, or reassign common variables
    function assign_common_variables() {
        global $user;
        global $user_id;
        global $user_record;

        //Retrieve user chat sessions
        $user_record = $user->read("telegram_user_id", $user_id)[0];
    }