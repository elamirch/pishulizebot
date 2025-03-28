<?php
switch ($update->callback_query->data) {
    case 'setbackground':
        $telegram->sendMessage($user_id, "تصویر یا ویدیوی مورد نظر خود را ارسال کنید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "background");
        break;
    
    case 'settext':
        $telegram->sendMessage($user_id, "متن مورد نظر خود را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text_1");
        break;
    
    case 'create_1':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null &&
            $results['text_two'] != null && $results['text_three'] != null &&
            $results['text_four'] != null && $results['text_five'] != null) {

                $memes->create_input_video($user_id, $results['background'], "memes/1-two-kitties-talking/1-tkt.mov");
                
                $texts = [break_string($results['text_one'], 32),
                break_string($results['text_two'], 14),
                break_string($results['text_three'], 32),
                break_string($results['text_four'], 14),
                break_string($results['text_five'], 14)];

                $output_file = $memes->create('1', $texts, $user_id);

                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_2':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
            $memes->create_input_video($user_id, $results['background'], "memes/2-brother-eww/2-brother-eww.mov");

            $output_file = $memes->create('2', break_string($results['text_one'], 28), $user_id);

            $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;

    case 'create_3':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/3-the-rock-sus/3-the-rock-sus.mov");

                $output_file = $memes->create('3', break_string($results['text_one'], 28), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_4':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/4-cage-and-pascal/4-cage-and-pascal.mov");
                
                $output_file = $memes->create('4', break_string($results['text_one'], 28), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_5':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/5-shocked-john-cena/5-shocked-john-cena.mov");
                
                $output_file = $memes->create('5', break_string($results['text_one'], 30), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;

    case 'create_6':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/6-juan-laughing/6-juan-laughing.mov");
                
                $output_file = $memes->create('6', break_string($results['text_one'], 28), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_7':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/7-driving-cat/7-driving-cat.mov");
                
                $output_file = $memes->create('7', break_string($results['text_one'], 30), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_8':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/8-mr-fresh-cat/8-mr-fresh-cat.mov");
                
                $output_file = $memes->create('8', break_string($results['text_one'], 28), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;

    case 'create_9':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/9-goat-and-clueless-cat/9-goat-n-kitty.mov");
                
                $output_file = $memes->create('9', break_string($results['text_one'], 30), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_10':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/10-kitty-saying-arreh/10-kitty-saying-arreh.mov");
                
                $output_file = $memes->create('10', break_string($results['text_one'], 28), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_11':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/11-donkey-eating/11-donkey-eating.mov");
                
                $output_file = $memes->create('11', break_string($results['text_one'], 30), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;

    case 'create_12':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
                $memes->create_input_video($user_id, $results['background'], "memes/12-hasbulla-counting-money/12-hasbulla-counting-money.mov");
                
                $output_file = $memes->create('12', break_string($results['text_one'], 28), $user_id);
                
                $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_13':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['text_one'] != null) {
                $output_file = $memes->create('13', break_string($results['text_one'], 40), $user_id);

                $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_14':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['text_one'] != null && $results['text_two'] != null && $results['text_three'] != null) {
                $output_file = $memes->create('14', [break_string($results['text_one'], 8),
                        break_string($results['text_two'], 12),
                        break_string($results['text_three'], 10)], $user_id);
                
                $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;

    case 'create_15':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['text_one'] != null) {
            $output_file = $memes->create('15', break_string($results['text_one'], 40), $user_id);
            
            $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;

    case 'create_16':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['text_one'] != null && $results['text_two'] != null) {
                $output_file = $memes->create('16', [break_string($results['text_one'], 22),
                    break_string($results['text_two'], 22)], $user_id);

                $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_17':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['text_one'] != null && $results['text_two'] != null && $results['text_three'] != null) {
                $output_file = $memes->create('17', [break_string($results['text_one'], 8),
                            break_string($results['text_two'], 10),
                            break_string($results['text_three'], 11)], $user_id);
                
                $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_18':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['text_one'] != null) {
                $output_file = $memes->create('18', break_string($results['text_one'],
                    40), $user_id);
                
                $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;

    case 'create_19':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['text_one'] != null && $results['text_two'] != null) {
            $output_file = $memes->create('19', [break_string($results['text_one'],
                    25), break_string($results['text_two'], 25)], $user_id);

            $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_20':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['text_one'] != null) {
            $output_file = $memes->create('20', break_string($results['text_one'],
                    40), $user_id);
            
            $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_21':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['text_one'] != null) {
            
            $output_file = $memes->create('21', break_string($results['text_one'],
                    40), $user_id);
            
            $telegram->sendPhoto($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;

    case 'create_22':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
            
            $memes->create_input_video($user_id, $results['background'], "memes/22-if-i-speak-im-in-big-trouble/22-if-i-speak-im-in-big-trouble.mov");
            
            $output_file = $memes->create('22', break_string($results['text_one'],
                    30), $user_id);
            
            $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;

    case 'create_23':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
            
            $memes->create_input_video($user_id, $results['background'], "memes/23-crying-dog/crying-dog.mov");
            
            $output_file = $memes->create('23', break_string($results['text_one'],
                    30), $user_id);

            $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_24':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
            
            $memes->create_input_video($user_id, $results['background'], "memes/24-cat-hitting-another-cat/cat-fight.mov");

            $output_file = $memes->create('24', break_string($results['text_one'],
                    30), $user_id);

            $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    case 'create_25':
        $results = $user->read("telegram_user_id", $user_id);
        if ($results['background'] != null && $results['text_one'] != null) {
            
            $memes->create_input_video($user_id, $results['background'], "memes/25-somebody-had-to-do-it/trump.mov");
            
            $output_file = $memes->create('25', break_string($results['text_one'],
                    30), $user_id);

            $telegram->sendVideo($user_id, $output_file, $MEME_CREATED_MESSAGE);
        } else {
            $telegram->sendMessage($user_id, "ساخت میم شکست خورد❗️\nلطفا تمام بخش‌ها را دوباره کامل کنید و سپس روی «ساخت میم» کلیک کنید");
        }
        break;
    
    //two kitties talking meme
    case 'settext1_tkt':
        $telegram->sendMessage($user_id, "متن اول را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text1tkt");
        break;

    case 'settext2_tkt':
        $telegram->sendMessage($user_id, "متن دوم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text2tkt");
        break;

    case 'settext3_tkt':
        $telegram->sendMessage($user_id, "متن سوم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text3tkt");
        break;

    case 'settext4_tkt':
        $telegram->sendMessage($user_id, "متن چهارم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text4tkt");
        break;

    case 'settext5_tkt':
        $telegram->sendMessage($user_id, "متن پنجم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text5tkt");
        break;
    
    //distracted boyfriend meme
    case 'settext1_dbf':
        $telegram->sendMessage($user_id, "متن اول را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text1dbf");
        break;

    case 'settext2_dbf':
        $telegram->sendMessage($user_id, "متن دوم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text2dbf");
        break;

    case 'settext3_dbf':
        $telegram->sendMessage($user_id, "متن سوم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text3dbf");
        break;
    
    //drakepost meme
    case 'settext1_dp':
        $telegram->sendMessage($user_id, "متن اول را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text1dp");
        break;

    case 'settext2_dp':
        $telegram->sendMessage($user_id, "متن دوم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text2dp");
        break;

    //exit 12 meme
    case 'settext1_e12':
        $telegram->sendMessage($user_id, "متن اول را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text1e12");
        break;

    case 'settext2_e12':
        $telegram->sendMessage($user_id, "متن دوم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text2e12");
        break;

    case 'settext3_e12':
        $telegram->sendMessage($user_id, "متن سوم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text3e12");
        break;

    //hide the pain meme
    case 'settext1_hdp':
        $telegram->sendMessage($user_id, "متن اول را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text1hdp");
        break;

    case 'settext2_hdp':
        $telegram->sendMessage($user_id, "متن دوم را بنویسید");
        $user->update("telegram_user_id", $user_id, "checkpoint", "text2hdp");
        break;

    default:
        # code...
        break;
}

if(substr($update->callback_query->data, 0, 6) == 'create') {
    $user->flush($user_id);
    if(isset($output_file) && file_exists($output_file)) {
        unlink($output_file);
    }
    if(file_exists("files/$user_id/input.mp4")) {
        unlink("files/$user_id/input.mp4");
    }
}