<?php

class Telegram {
    public function getChatMember($user_id)
    {
        global $BOT_TOKEN;
        global $ASSOCIATED_CHANNEL;
        $url = "https://api.telegram.org/bot$BOT_TOKEN/getChatMember";
        $data = array(
            "chat_id" => "@$ASSOCIATED_CHANNEL",
            "user_id" => $user_id
        );
        return curl($url,$data);
    }
    
    public function sendMessage($user_id, $text, $reply_markup = '') {
        global $BOT_TOKEN;
        $url = "https://api.telegram.org/bot$BOT_TOKEN/sendMessage";
        $data = array(
            "chat_id" => $user_id,
            "text" => $text,
            "reply_markup" => $reply_markup
        );
        return curl($url,$data);
    }
    
    public function getUpdates($offset) {
        global $BOT_TOKEN;
        $url = "https://api.telegram.org/bot$BOT_TOKEN/getUpdates";
        $data = array(
            "offset" => $offset
        );
        return curl($url,$data);
    }

    public function sendVideo($user_id, $videoPath, $caption, $reply_markup = null) {
        global $BOT_TOKEN;

        $data = array(
            'chat_id' => "$user_id",
            'video' => new \CURLFile($videoPath),
            'caption' => $caption,
        );

        if($reply_markup !=null) {
            $data['reply_markup'] = urldecode($reply_markup);
        }

        $url = "https://api.telegram.org/bot$BOT_TOKEN/sendVideo";
        curl($url, $data);
    }

    public function sendPhoto($user_id, $photoPath, $caption, $reply_markup = null) {
        global $BOT_TOKEN;
        $data = array(
            'chat_id' => "$user_id",
            'photo' => new \CURLFile($photoPath),
            'caption' => $caption,
        );

        if($reply_markup !=null) {
            $data['reply_markup'] = urldecode($reply_markup);
        }

        $url = "https://api.telegram.org/bot$BOT_TOKEN/sendPhoto";
        curl($url, $data);
    }

    public function getFile($file_id) {
        global $BOT_TOKEN;
        $data = array(
            'file_id' => "$file_id",
        );

        $url = "https://api.telegram.org/bot$BOT_TOKEN/getFile";
        return curl($url, $data);
    }

    function download($user_id, $file_path){
        global $BOT_TOKEN;
        global $USE_PROXY;
    
        $url = "https://api.telegram.org/file/bot$BOT_TOKEN/$file_path";
        if(!is_dir("files/$user_id")){
            mkdir("files/$user_id");
        }
        $file_name = uniqid("input");
        
        if($USE_PROXY) {
            $proxy_setting = array(
                'http' => array(
                    'proxy' => 'tcp://127.0.0.1:2081',
                    'request_fulluri' => true,
                ),
            );

            $stream_context = stream_context_create($proxy_setting);

            $downloaded_file = file_get_contents($url, False, $stream_context);
        } else {
            $downloaded_file = file_get_contents($url, False);
        }
        logMessage("Downloading " . $url);

        if (file_put_contents("files/" . $user_id . "/" . $file_name,
                $downloaded_file))
        { 
            logMessage("File downloaded successfully");
            return $file_name;
        } 
        else
        { 
            logMessage("File downloading failed");
            return False;
        } 
    }
}