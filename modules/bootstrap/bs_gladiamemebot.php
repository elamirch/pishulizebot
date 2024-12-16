<?php
    echo "Running\n";
    
    //Reading variables from .env file
    $env = parse_ini_file('.env');
    
    $BOT_TOKEN = $env['GLADIAMEMEBOT_TOKEN'];
        
    $DB_NAME = $env['GLADIAMEMEBOT_DB_NAME'];
    $DB_USER = $env['GLADIAMEMEBOT_DB_USER'];
    $DB_PASS = $env['GLADIAMEMEBOT_DB_PASS'];

    $ASSOCIATED_CHANNEL = $env['GLADIAMEMEBOT_ASSOCIATED_CHANNEL'];

    include_once("./modules/buttons/bt_gladiamemebot.php");