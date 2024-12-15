<?php
class Memes {
    public function create($meme_id, array $texts, $user_id) {
        switch ($meme_id) {
            case '1':
                return $this->create_tkt_meme($user_id, $texts);
            case '2':
                return $this->create_simple_video_meme($user_id, $texts);
            case '3':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '4':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '5':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '6':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '7':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '8':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '9':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '10':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '11':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '12':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '13':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '14':
                return $this->create_distracted_bf_meme($user_id, $texts);
            case '15':
                return $this->create_simple_photo_meme($user_id, $texts  , "memes/15-evil-kermit/evil-kermit.png");
            case '16':
                return $this->create_drakepost_meme($user_id, $texts);
            case '17':
                return $this->create_exit12_meme($user_id, $texts);
            case '18':
                return $this->create_simple_photo_meme($user_id, $texts  , "memes/18-facepalm/facepalm.png");
            case '19':
                return $this->create_hide_the_pain_meme($user_id, $texts);
            case '20':
                return $this->create_simple_photo_meme($user_id, $texts  , "memes/20-spiderman/spiderman.png");
            case '21':
                return $this->create_simple_photo_meme($user_id, $texts  , "memes/21-think-bruh/think-bruh.png");
            case '22':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '23':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '24':
                return $this->create_simple_video_meme($user_id, $texts  );
            case '25':
                return $this->create_simple_video_meme($user_id, $texts  );
            default:
                # code...
                break;
        }
    }

    public function create_input_video($user_id, $background, $meme_overlay_path) {
    
        exec("ffprobe -v error -select_streams v -show_entries stream=width,height -of json files/$user_id/$background", $ff_output);
        
        $height = json_decode(implode(" ", $ff_output))->streams[0]->height;
        $width = json_decode(implode(" ", $ff_output))->streams[0]->width;
        
        echo "\nWidth: " . $width . ", Height: " . $height;
    
        if($height > $width*1.77777) {
            //for a too long vertical image
            //scale to 576 wide
            exec("ffmpeg -i files/$user_id/$background -vf \"scale=576:trunc(ow/a/2)*2\" -c:v libx264 -c:a copy files/$user_id/scaled.mp4");
        } else {
            //for a horizontal image or short vertical image
            //scale to 1024 high
            exec("ffmpeg -i files/$user_id/$background -vf \"scale=trunc(oh*a/2)*2:1024\" -c:v libx264 -c:a copy files/$user_id/scaled.mp4");
        }
    
        //crop to 576x1024
        exec("ffmpeg -i files/$user_id/scaled.mp4 -filter:v \"crop=576:1024:1:1\" files/$user_id/cropped.mp4");
        //add overlay
        exec("ffmpeg -i files/$user_id/cropped.mp4 -i $meme_overlay_path -filter_complex \"[0:v][1:v]overlay=0:0[v]\" -map \"[v]\" -map 1:a -c:v libx264 -c:a aac -strict -2 files/$user_id/input.mp4");
    
        unlink("files/$user_id/$background");
        unlink("files/$user_id/cropped.mp4");
        unlink("files/$user_id/scaled.mp4");
    }

    private function create_tkt_meme($user_id, $texts) {
        //add texts
        $dada_one = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[0]))));
        $meow_one = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[1]))));
        $dada_two = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[2]))));
        $meow_two = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[3]))));
        $meow_three = str_replace('0@0', "\n", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[4]))));
    
        $output_file = uniqid("output");
        exec("ffmpeg -i files/$user_id/input.mp4 -vf \"" .
        "drawtext=text='‫$dada_one':fontfile=Vazirmatn-Regular.ttf:fontsize=32" .
        ":fontcolor=black:x=80:y=320:box=1:boxcolor=white@0.8:enable='between(t,0,2)' , drawtext=text='$meow_one':" .
        "fontfile=Vazirmatn-Regular.ttf:fontsize=32:fontcolor=black:x=380:y=350:box=1:boxcolor=white@0.8:enable='between(t,2.8,4)' ," .
        "drawtext=text='$dada_two':fontfile=Vazirmatn-Regular.ttf:fontsize=32:" .
        "fontcolor=black:x=80:y=320:box=1:boxcolor=white@0.8:enable='between(t,4.5,8.5)' , drawtext=text='$meow_two':" .
        "fontfile=Vazirmatn-Regular.ttf:fontsize=32:fontcolor=black:x=380:y=350:box=1:boxcolor=white@0.8:enable='between(t,8.7,10)' ," .
        "drawtext=text='$meow_three':fontfile=Vazirmatn-Regular.ttf:fontsize=32:fontcolor=black:x=380:y=350:" .
        "box=1:boxcolor=white@0.8:enable='between(t,11,12)' \" -c:v libx264 -c:a copy files/$user_id/$output_file.mp4 2>&1", $op);
    
        unlink("files/$user_id/input.mp4");
        return "files/$user_id/$output_file.mp4";
    }

    private function create_simple_video_meme($user_id, $text) {
        //add texts
        $text_refined = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text))));
        $output_file = uniqid("output");
        exec("ffmpeg -i files/$user_id/input.mp4 -vf \"drawtext=text='‫$text_refined':fontfile=Vazirmatn-Regular.ttf:fontsize=36:" .
        "fontcolor=black:x=50:y=150:box=1:boxcolor=white@0.8:boxborderw=5 \" -c:v libx264 -c:a " .
        "copy files/$user_id/$output_file.mp4 2>&1", $op);

        return "files/$user_id/$output_file.mp4";
    }

    private function create_simple_photo_meme($user_id, $text, $meme_path) {

        $text_refined = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $text))));
        $output_file = uniqid("output");
        
        exec("ffmpeg -i $meme_path -vf \"drawtext=text='‫$text_refined':" .
        "fontfile=Vazirmatn-Regular.ttf:fontsize=36:fontcolor=black:x=50:y=50:box=1:" .
        "boxcolor=white@0.8:boxborderw=5 ,format=rgb24\" -frames:v 1 files/$user_id/$output_file.png", $op);
        return "files/$user_id/$output_file.mp4";
    }

    private function create_distracted_bf_meme($user_id, $texts) {
        $text_1_dbf = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[0]))));
        $text_2_dbf = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[1]))));
        $text_3_dbf = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[2]))));
        $output_file = uniqid("output");
        
        exec("ffmpeg -i memes/14-distracted-boyfriend/distracted-boyfriend.png -vf \"drawtext=text='‫$text_1_dbf':fontfile=".
        "Vazirmatn-Regular.ttf:fontsize=24:fontcolor=black:x=630:y=310:box=1:boxcolor=white@0.8:".
        "boxborderw=5 ,drawtext=text='‫$text_2_dbf':fontfile=Vazirmatn-Regular.ttf:fontsize=24:fontcolor=".
        "black:x=430:y=260:box=1:boxcolor=white@0.8:boxborderw=5 ,drawtext=text='‫$text_3_dbf':".
        "fontfile=Vazirmatn-Regular.ttf:fontsize=36:fontcolor=black:x=100:y=400:box=1:".
        "boxcolor=white@0.8:boxborderw=5 ,format=rgb24\" -frames:v 1 files/$user_id/$output_file.png", $op);
        return "files/$user_id/$output_file.mp4";
    }

    private function create_drakepost_meme($user_id, $texts) {
        $text_1_dp = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[0]))));
        $text_2_dp = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[1]))));
        $output_file = uniqid("output");
        
        exec("ffmpeg -i memes/16-drakepost/drakepost.png -vf \"drawtext=text='‫$text_1_dp':fontfile=".
        "Vazirmatn-Regular.ttf:fontsize=36:fontcolor=black:x=400:y=50:box=1:boxcolor=white@0.8:".
        "boxborderw=5 ,drawtext=text='‫$text_2_dp':fontfile=Vazirmatn-Regular.ttf:fontsize=36:fontcolor=".
        "black:x=400:y=450:box=1:boxcolor=white@0.8:boxborderw=5 ,format=rgb24\" -frames:v 1 files/$user_id/$output_file.png", $op);
        return "files/$user_id/$output_file.mp4";
    }

    function create_exit12_meme($user_id, $texts) {
        $text_1_e12 = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[0]))));
        $text_2_e12 = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[1]))));
        $text_3_e12 = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[2]))));
        $output_file = uniqid("output");
        
        exec("ffmpeg -i memes/17-exit-12/exit-12.png -vf \"drawtext=text='‫$text_1_e12':fontfile=Vazirmatn-Regular.ttf".
        ":fontsize=24:fontcolor=black:x=200:y=120:box=1:boxcolor=white@0.8:boxborderw=5 ,".
        "drawtext=text='‫$text_2_e12':fontfile=Vazirmatn-Regular.ttf:fontsize=24:fontcolor=black".
        ":x=420:y=120:box=1:boxcolor=white@0.8:boxborderw=5 ,drawtext=text='‫$text_3_e12':fontfile".
        "=Vazirmatn-Regular.ttf:fontsize=24:fontcolor=black:x=335:y=540:box=1:boxcolor=".
        "white@0.8:boxborderw=5 ,format=rgb24\" -frames:v 1 files/$user_id/$output_file.png", $op);
        
        return "files/$user_id/$output_file.mp4";
    }

    function create_hide_the_pain_meme($user_id, $texts) {
        $text_1_hdp = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[0]))));
        $text_2_hdp = str_replace('0@0', "\n‫", str_replace(':', '\:', escapeshellcmd(implode('0@0', $texts[1]))));
        $output_file = uniqid("output");
        
        exec("ffmpeg -i memes/19-hide-the-pain-harold/hide-the-pain-harold.png -vf \"drawtext=text='‫$text_1_hdp':fontfile=Vazirmatn-Regular.ttf".
        ":fontsize=45:fontcolor=black:x=110:y=100:box=1:boxcolor=white@0.8:boxborderw=5 ,drawtext=text='‫$text_2_hdp'".
        ":fontfile=Vazirmatn-Regular.ttf:fontsize=45:fontcolor=black:x=210:y=1180:box=1:boxcolor=white@0.8:".
        "boxborderw=5 ,format=rgb24\" -frames:v 1 files/$user_id/$output_file.png", $op);
        return "files/$user_id/$output_file.mp4";
    }
}
