<?php
    ini_set("error_log", "/tmp/pishulize-errors.log");
    $logFile = "/tmp/pishulize-logs.log";
    //Reading variables from .env file
    $env = parse_ini_file('.env');

    $BOT_TOKEN = $env['PISHULIZEBOT_TOKEN'];
        
    $DB_NAME = $env['PISHULIZEBOT_DB_NAME'];
    $DB_USER = $env['PISHULIZEBOT_DB_USER'];
    $DB_PASS = $env['PISHULIZEBOT_DB_PASS'];
    
    $ASSOCIATED_CHANNEL = $env['PISHULIZEBOT_ASSOCIATED_CHANNEL'];

    include_once("./modules/buttons/bt_pishulizebot.php");