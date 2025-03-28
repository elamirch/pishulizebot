<?php
switch ($checkpoint) {
    case 'background':
        setCheckpoint('background');
        $message = "Send a background photo or video...";
        break;
    
    case 'text_1':
        setCheckpoint('');
        userUpdate('text_one', $text);
        $message = "Text was set, click on \"Create meme\" to create the meme";

        break;
    
    case 'text1tkt':
        setCheckpoint('text2tkt');
        userUpdate('text_one', $text);
        $message = "First text was set, now write the second text...";
        
        break;
    
    case 'text2tkt':
        setCheckpoint('text3tkt');
        userUpdate('text_two', $text);
        $message = "Second text was set, now write the third text...";

        break;

    case 'text3tkt':
        setCheckpoint('text4tkt');
        userUpdate('text_three', $text);
        $message = "Third text was set, now write the fourth text...";

        break;
    
    case 'text4tkt':
        setCheckpoint('text5tkt');
        userUpdate('text_four', $text);
        $message = "Fourth text was set, now write the fifth text...";

        break;
    
    case 'text5tkt':
        setCheckpoint('');
        userUpdate('text_five', $text);
        $message =  "Fifth text was set, if you're finished with all the texts, ".
                    "click on the \"Create meme\" button";

        break;

    case 'text1dbf':
        setCheckpoint('text2dbf');
        userUpdate('text_one', $text);
        $message = "First text set, now write the second text...";

        break;
    
    case 'text2dbf':
        setCheckpoint('text3dbf');
        userUpdate('text_two', $text);
        $message = "Second text set, now write the third text...";

        break;

    case 'text3dbf':
        setCheckpoint('');
        userUpdate('text_three', $text);
        $message =  "Third text was set, if you're finished with all the texts, ".
                    "click on the \"Create meme\" button";
        
        break;

    case 'text1dp':
        setCheckpoint('text2dp');
        userUpdate('text_one', $text);
        $message = "First text was set, now write the second text...";

        break;
    
    case 'text2dp':
        setCheckpoint('');
        userUpdate('text_two', $text);
        $message =  "Second text was set, if you're finished with all the texts, ".
                    "click on the \"Create meme\" button";

        break;

    case 'text1e12':
        setCheckpoint('text2e12');
        userUpdate('text_one', $text);
        $message = "First text was set, now write the second text...";

        break;
    
    case 'text2e12':
        setCheckpoint('text3e12');
        userUpdate('text_two', $text);
        $message = "Second text was set, now write the third text...";

        break;
    
    case 'text3e12':
        setCheckpoint('');
        userUpdate('text_three', $text);
        $message =  "Third text was set, if you're finished with all the texts, ".
                    "click on the \"Create meme\" button";

        break;

    case 'text1hdp':
        setCheckpoint('text2hdp');
        userUpdate('text_one', $text);
        $message = "First text was set, now write the second text...";

        break;
    
    case 'text2hdp':
        setCheckpoint('');
        userUpdate('text_two', $text);
        $message =  "Second text was set, if you're finished with all the texts, ".
                    "click on the \"Create meme\" button";

        break;
}

dm($message);