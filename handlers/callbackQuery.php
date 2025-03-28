<?php

switch ($update->callback_query->data) {
    case 'setbackground':
        setCheckpoint("background");
        dm("Send a background photo or video...");
        break;
    
    case 'settext':
        setCheckpoint("text_1");
        dm("Write the text you want on the meme...");
        break;
    
    case 'create_1':
        $inputs = ['background', 'text_one', 'text_two', 'text_three', 'text_four', 'text_five'];

        if (validateOrDmError($inputs)) {

            createInputVideo(
                "memes/1-two-kitties-talking/1-tkt.mov"
            );
            
            $texts = [
                break_string($user_record['text_one'], 32),
                break_string($user_record['text_two'], 14),
                break_string($user_record['text_three'], 32),
                break_string($user_record['text_four'], 14),
                break_string($user_record['text_five'], 14)
            ];

            $output_file = createMeme('1', $texts);

            sendVideoMeme($output_file);
        }
        break;
    
    case 'create_2':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {

            createInputVideo(
                "memes/2-brother-eww/2-brother-eww.mov"
            );

            $text = break_string($user_record['text_one'], 28);

            $output_file = createMeme('2', $texts);

            sendVideoMeme($output_file);
        }
        break;

    case 'create_3':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {

            createInputVideo(
                "memes/3-the-rock-sus/3-the-rock-sus.mov"
            );

            $text = break_string($user_record['text_one'], 28);

            $output_file = createMeme('3', $texts);
            
            sendVideoMeme($output_file);
        }
        break;
    
    case 'create_4':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {

            createInputVideo(
                "memes/4-cage-and-pascal/4-cage-and-pascal.mov"
            );

            $text = break_string($user_record['text_one'], 28);
            
            $output_file = createMeme('4', $texts);
            
            sendVideoMeme($output_file);
        }
        break;
    
    case 'create_5':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {

            createInputVideo(
                "memes/5-shocked-john-cena/5-shocked-john-cena.mov"
            );
            
            $text = break_string($user_record['text_one'], 30);

            $output_file = createMeme('5', $texts);
            
            sendVideoMeme($output_file);
        }

        break;

    case 'create_6':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {

            createInputVideo(
                "memes/6-juan-laughing/6-juan-laughing.mov"
            );
            
            $text = break_string($user_record['text_one'], 28);

            $output_file = createMeme('6', $texts);
            
            sendVideoMeme($output_file);
        }

        break;
    
    case 'create_7':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {

            createInputVideo(
                "memes/7-driving-cat/7-driving-cat.mov"
            );
            
            $text = break_string($user_record['text_one'], 28);
            $output_file = createMeme('7', $texts);
            
            sendVideoMeme($output_file);
        }

        break;
    
    case 'create_8':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {

            createInputVideo("memes/8-mr-fresh-cat/8-mr-fresh-cat.mov");
            $texts = break_string($user_record['text_one'], 28);
            $output_file = createMeme('8', $texts);
            
            sendVideoMeme($output_file);
        }

        break;

    case 'create_9':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {
            $texts = break_string($user_record['text_one'], 30);
            $output_file = createMeme('9', $texts);
            
            sendVideoMeme($output_file);
        }
        
        break;
    
    case 'create_10':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {

            createInputVideo("memes/10-kitty-saying-arreh/10-kitty-saying-arreh.mov");
        
            $texts = break_string($user_record['text_one'], 28);
            $output_file = createMeme('10', $texts);
            
            sendVideoMeme($output_file);
        }
        break;
    
    case 'create_11':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {
            createInputVideo("memes/11-donkey-eating/11-donkey-eating.mov");
            
            $texts = break_string($user_record['text_one'], 30);
            $output_file = createMeme('1', $texts);
            
            sendVideoMeme($output_file);
        }
        
        break;

    case 'create_12':
        $inputs = ['background', 'text_one'];

        if (validateOrDmError($inputs)) {
            createInputVideo("memes/12-hasbulla-counting-money/12-hasbulla-counting-money.mov");
            $texts = break_string($user_record['text_one'], 28);
            $output_file = createMeme('12', $texts);
            sendVideoMeme($output_file);
        }
        
        break;
    
    case 'create_13':
        $inputs = ['text_one'];

        if (validateOrDmError($inputs)) {
            $texts = [
                break_string($user_record['text_one'], 40)
            ];
            $output_file = createMeme('15', $texts);
            sendPhotoMeme($output_file);
        }
        
        break;
    
    case 'create_14':
        $inputs = ['text_one', 'text_two', 'text_three'];

        if (validateOrDmError($inputs)) {
            $texts = [
                break_string($user_record['text_one'], 8),
                break_string($user_record['text_two'], 12),
                break_string($user_record['text_three'], 11)
            ];
            $output_file = createMeme('14', $texts);
            sendPhotoMeme($output_file);
        }
        
        break;

    case 'create_15':
        $inputs = ['text_one'];

        if (validateOrDmError($inputs)) {
            $texts = [
                break_string($user_record['text_one'], 40)
            ];
            $output_file = createMeme('15', $texts);
            sendPhotoMeme($output_file);
        }
        
        break;

    case 'create_16':
        $inputs = ['text_one', 'text_two'];

        if (validateOrDmError($inputs)) {
            $texts = [
                break_string($user_record['text_one'], 22),
                break_string($user_record['text_two'], 22)
            ];
            $output_file = createMeme('16', $texts);
            sendPhotoMeme($output_file);
        }
        
        break;
    
    case 'create_17':
        $inputs = ['text_one', 'text_two', 'text_three'];

        if (validateOrDmError($inputs)) {
            $texts = [
                break_string($user_record['text_one'], 8),
                break_string($user_record['text_two'], 10),
                break_string($user_record['text_three'], 11)
            ];
            $output_file = createMeme('17', $texts);
            sendPhotoMeme($output_file);
        }
        
        break;
    
    case 'create_18':
        $inputs = ['text_one'];

        if (validateOrDmError($inputs)) {
            $texts = break_string($user_record['text_one'], 40);
            $output_file = createMeme('18', $texts);
            sendPhotoMeme($output_file);
        }
        
        break;

    case 'create_19':
        $inputs = ['text_one', 'text_two', 'text_three'];

        if (validateOrDmError($inputs)) {

            $texts = [
                break_string($user_record['text_one'], 25),
                break_string($user_record['text_two'], 25)
            ];
            $output_file = createMeme('19', $texts);

            sendVideoMeme($output_file);
        }
        
        break;
    
    case 'create_20':
        $inputs = ['text_one'];

        if (validateOrDmError($inputs)) {

            $texts = break_string($user_record['text_one'], 40);
            $output_file = createMeme('20', $texts);
            
            sendVideoMeme($output_file);
        }
        
        break;
    
    case 'create_21':
        $inputs = ['text_one'];

        if (validateOrDmError($inputs)) {
            
            $texts = break_string($user_record['text_one'], 40);
            $output_file = createMeme('21', $texts);
            
            sendVideoMeme($output_file);
        }
        
        break;

    case 'create_22':
        $inputs = ['text_one', 'background'];

        if (validateOrDmError($inputs)) {
            
            createInputVideo("memes/22-if-i-speak-im-in-big-trouble/22-if-i-speak-im-in-big-trouble.mov");
            
            $texts = break_string($user_record['text_one'], 30);
            $output_file = createMeme('22', $texts);
            
            sendVideoMeme($output_file);
        }
        
        break;

    case 'create_23':
        $inputs = ['text_one', 'background'];

        if (validateOrDmError($inputs)) {
            
            createInputVideo("memes/23-crying-dog/crying-dog.mov");
            
            $texts = break_string($user_record['text_one'], 30);
            $output_file = createMeme('23', $texts);

            sendVideoMeme($output_file);
        }

        break;
    
    case 'create_24':
        $inputs = ['text_one', 'background'];

        if (validateOrDmError($inputs)) {
            
            createInputVideo("memes/24-cat-hitting-another-cat/cat-fight.mov");

            $texts = break_string($user_record['text_one'], 30);
            $output_file = createMeme('24', $texts);

            sendVideoMeme($output_file);
        }

        break;
    
    case 'create_25':
        $inputs = ['text_one', 'background'];

        if (validateOrDmError($inputs)) {
            createInputVideo("memes/25-somebody-had-to-do-it/trump.mov");

            $texts = break_string($user_record['text_one'], 30);
            $output_file = createMeme('25', $texts);

            sendVideoMeme($output_file);
        }

        break;
    
    //two kitties talking meme
    case 'settext1_tkt':
        dm("Write the first text...");
        setCheckpoint("text1tkt");
        break;

    case 'settext2_tkt':
        dm("Write the second text...");
        setCheckpoint("text2tkt");
        break;

    case 'settext3_tkt':
        dm("Write the third text...");
        setCheckpoint("text3tkt");
        break;

    case 'settext4_tkt':
        dm("Write the fourth text...");
        setCheckpoint("text4tkt");
        break;

    case 'settext5_tkt':
        dm("Write the fifth text...");
        setCheckpoint("text5tkt");
        break;
    
    //distracted boyfriend meme
    case 'settext1_dbf':
        dm("Write the first text...");
        setCheckpoint("text1dbf");
        break;

    case 'settext2_dbf':
        dm("Write the second text...");
        setCheckpoint("text2dbf");
        break;

    case 'settext3_dbf':
        dm("Write the third text...");
        setCheckpoint("text3dbf");
        break;
    
    //drakepost meme
    case 'settext1_dp':
        dm("Write the first text...");
        setCheckpoint("text1dp");
        break;

    case 'settext2_dp':
        dm("Write the second text...");
        setCheckpoint("text2dp");
        break;

    //exit 12 meme
    case 'settext1_e12':
        dm("Write the first text...");
        setCheckpoint("text1e12");
        break;

    case 'settext2_e12':
        dm("Write the second text...");
        setCheckpoint("text2e12");
        break;

    case 'settext3_e12':
        dm("Write the third text...");
        setCheckpoint("text3e12");
        break;

    //hide the pain meme
    case 'settext1_hdp':
        dm("Write the first text...");
        setCheckpoint("text1hdp");
        break;

    case 'settext2_hdp':
        dm("Write the second text...");
        setCheckpoint("text2hdp");
        break;
}

//Empty all the inputs in the database and delete all unneeded files
if(substr($update->callback_query->data, 0, 6) == 'create') {
    $user->flush($user_id);
    if(isset($output_file) && file_exists($output_file)) {
        unlink($output_file);
    }
    if(file_exists("files/$user_id/input.mp4")) {
        unlink("files/$user_id/input.mp4");
    }
}