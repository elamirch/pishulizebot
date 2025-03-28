<?php
    ini_set("log_errors", 1);
    ini_set("error_log", "/tmp/gladiameme-errors.log");
    $USE_PROXY = $env['USE_PROXY'];
    
    $DB_HOST = $env['DB_HOST'];
    $DB_PORT = $env['DB_PORT'];
    //DB_NAME, DB_USER and DB_PASS are derived from bot_specific files
    
    $DISPLAY_ERRORS = $env['DISPLAY_ERRORS'];

    $ADMIN_CHAT_ID = $env['ADMIN_CHAT_ID'];
    $ADMIN_USER_NAME = $env['ADMIN_USER_NAME'];

    //Setting wether to display errors
    if($DISPLAY_ERRORS) {
        ini_set('display_errors', "on");
        error_reporting(error_level: E_ALL);
    }

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