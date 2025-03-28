<?php
    ini_set("log_errors", 1);
    $USE_PROXY = $env['USE_PROXY'];
    
    $DB_HOST = $env['DB_HOST'];
    $DB_PORT = $env['DB_PORT'];
    //DB_NAME, DB_USER and DB_PASS are derived from bot_specific files
    
    $DISPLAY_ERRORS = $env['DISPLAY_ERRORS'];

    $ADMIN_CHAT_ID = $env['ADMIN_CHAT_ID'];
    $ADMIN_USER_NAME = $env['ADMIN_USER_NAME'];

    include_once("./modules/curl.php");
    include_once("./modules/db.php");
    include_once("./classes/telegram.php");
    include_once("./classes/user.php");
    include_once("./classes/memes.php");
    include_once("./modules/helperFunctions.php");
    
    //Create the needed objects
    $user = new User;
    $telegram = new Telegram;
    $memes = new Memes;
    
    if(!is_dir("files")){
        mkdir("files");
    }