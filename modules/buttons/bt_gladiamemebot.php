<?php

//main menu
$meme_1 = [
    'text' => '1- Talking Cats 😺😿',
];
$meme_2 = [
    'text' => '2- Brother Eww! 👳🏽',
];
$meme_3 = [
    'text' => '3- The Rock\'s Eyebrow 🤨',
];
$meme_4 = [
    'text' => '4- Nicolas Cage & Pedro Pascal 😕🤪',
];
$meme_5 = [
    'text' => '5- John Cena Shocked 😱',
];
$meme_6 = [
    'text' => '6- Juan\'s Laughter 🤣',
];
$meme_7 = [
    'text' => '7- Driver Cat 😽🚖',
];
$meme_8 = [
    'text' => '8- Mr. Fresh\'s Cat 😼',
];
$meme_9 = [
    'text' => '9- Goat & Kitty 🐐🐈‍⬛',
];
$meme_10 = [
    'text' => '10- Sleepy Kitty 😿',
];
$meme_11 = [
    'text' => '11- Chewing Donkey 🐴',
];
$meme_12 = [
    'text' => '12- Hasbulla Counting Money 💵',
];
$meme_13 = [
    'text' => '13- Disaster Girl 😏',
];
$meme_14 = [
    'text' => '14- Distracted Boyfriend 🤤',
];
$meme_15 = [
    'text' => '15- Kermit\'s Evil Advices 😈',
];
$meme_16 = [
    'text' => '16- Drakepost 🤚🏾👉🏾',
];
$meme_17 = [
    'text' => '17- Exit 12 ⬆️↗️',
];
$meme_18 = [
    'text' => '18- Facepalm 😑',
];
$meme_19 = [
    'text' => '19- Hide The Pain Harold 😅',
];
$meme_20 = [
    'text' => '20- Spidermans 🕸',
];
$meme_21 = [
    'text' => '21- Think Bro! 😎',
];
$meme_22 = [
    'text' => "22- Mourinho: If I speak I'm in big trouble",
];
$meme_23 = [
    'text' => '23- Crying Dog 😭',
];
$meme_24 = [
    'text' => '24- Cat Fight 😾🔥',
];
$meme_25 = [
    'text' => '25- Trump: Somebody had to do it',
];

$meme_selector_keyboard_markup = [
    'keyboard' => [
        [$meme_1], [$meme_2], [$meme_3], [$meme_4], [$meme_5],
        [$meme_6], [$meme_7], [$meme_8], [$meme_9], [$meme_10],
        [$meme_11], [$meme_12], [$meme_13], [$meme_14], [$meme_15],
        [$meme_16], [$meme_17], [$meme_18], [$meme_19], [$meme_20],
        [$meme_21], [$meme_22], [$meme_23], [$meme_24], [$meme_25],
    ],
];
//encode
$meme_selector_markup_encoded = json_encode($meme_selector_keyboard_markup);

//________________________________________________________
//________________________________________________________
//___________________meme inline menus____________________
//________________________________________________________
//________________________________________________________
//________________________________________________________
$set_background_button = [
    'text' => 'Set background photo/video',
    'callback_data' => 'setbackground',
];
$set_text_button = [
    'text' => 'Set text',
    'callback_data' => 'settext',
];
//render buttons
$render_button_1 = [
    'text' => 'Create meme',
    'callback_data' => 'create_1',
];
$render_button_2 = [
    'text' => 'Create meme',
    'callback_data' => 'create_2',
];
$render_button_3 = [
    'text' => 'Create meme',
    'callback_data' => 'create_3',
];
$render_button_4 = [
    'text' => 'Create meme',
    'callback_data' => 'create_4',
];
$render_button_5 = [
    'text' => 'Create meme',
    'callback_data' => 'create_5',
];
$render_button_6 = [
    'text' => 'Create meme',
    'callback_data' => 'create_6',
];
$render_button_7 = [
    'text' => 'Create meme',
    'callback_data' => 'create_7',
];
$render_button_8 = [
    'text' => 'Create meme',
    'callback_data' => 'create_8',
];
$render_button_9 = [
    'text' => 'Create meme',
    'callback_data' => 'create_9',
];
$render_button_10 = [
    'text' => 'Create meme',
    'callback_data' => 'create_10',
];
$render_button_11 = [
    'text' => 'Create meme',
    'callback_data' => 'create_11',
];
$render_button_12 = [
    'text' => 'Create meme',
    'callback_data' => 'create_12',
];
$render_button_13 = [
    'text' => 'Create meme',
    'callback_data' => 'create_13',
];
$render_button_14 = [
    'text' => 'Create meme',
    'callback_data' => 'create_14',
];
$render_button_15 = [
    'text' => 'Create meme',
    'callback_data' => 'create_15',
];
$render_button_16 = [
    'text' => 'Create meme',
    'callback_data' => 'create_16',
];
$render_button_17 = [
    'text' => 'Create meme',
    'callback_data' => 'create_17',
];
$render_button_18 = [
    'text' => 'Create meme',
    'callback_data' => 'create_18',
];
$render_button_19 = [
    'text' => 'Create meme',
    'callback_data' => 'create_19',
];
$render_button_20 = [
    'text' => 'Create meme',
    'callback_data' => 'create_20',
];
$render_button_21 = [
    'text' => 'Create meme',
    'callback_data' => 'create_21',
];
$render_button_22 = [
    'text' => 'Create meme',
    'callback_data' => 'create_22',
];
$render_button_23 = [
    'text' => 'Create meme',
    'callback_data' => 'create_23',
];
$render_button_24 = [
    'text' => 'Create meme',
    'callback_data' => 'create_24',
];
$render_button_25 = [
    'text' => 'Create meme',
    'callback_data' => 'create_25',
];
$meme_setting_markup_2 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_2],
    ]
];
$meme_setting_markup_2_encoded = json_encode($meme_setting_markup_2);
$meme_setting_markup_3 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_3],
    ]
];
$meme_setting_markup_3_encoded = json_encode($meme_setting_markup_3);
$meme_setting_markup_4 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_4],
    ]
];
$meme_setting_markup_4_encoded = json_encode($meme_setting_markup_4);
$meme_setting_markup_5 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_5],
    ]
];
$meme_setting_markup_5_encoded = json_encode($meme_setting_markup_5);
$meme_setting_markup_6 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_6],
    ]
];
$meme_setting_markup_6_encoded = json_encode($meme_setting_markup_6);
$meme_setting_markup_7 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_7],
    ]
];
$meme_setting_markup_7_encoded = json_encode($meme_setting_markup_7);
$meme_setting_markup_8 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_8],
    ]
];
$meme_setting_markup_8_encoded = json_encode($meme_setting_markup_8);
$meme_setting_markup_9 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_9],
    ]
];
$meme_setting_markup_9_encoded = json_encode($meme_setting_markup_9);
$meme_setting_markup_10 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_10],
    ]
];
$meme_setting_markup_10_encoded = json_encode($meme_setting_markup_10);
$meme_setting_markup_11 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_11],
    ]
];
$meme_setting_markup_11_encoded = json_encode($meme_setting_markup_11);
$meme_setting_markup_12 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_12],
    ]
];
$meme_setting_markup_12_encoded = json_encode($meme_setting_markup_12);
//just text
$meme_setting_markup_13 = [
    'inline_keyboard' => [
        [$set_text_button],
        [$render_button_13],
    ]
];
$meme_setting_markup_13_encoded = json_encode($meme_setting_markup_13);

//meme 14 confs moved to it's own section at the bottom

$meme_setting_markup_15 = [
    'inline_keyboard' => [
        [$set_text_button],
        [$render_button_15],
    ]
];
$meme_setting_markup_15_encoded = json_encode($meme_setting_markup_15);

//meme 16 & 17 confs moved to it's own section at the bottom

$meme_setting_markup_18 = [
    'inline_keyboard' => [
        [$set_text_button],
        [$render_button_18],
    ]
];
$meme_setting_markup_18_encoded = json_encode($meme_setting_markup_18);

//meme 16 & 17 confs moved to it's own section at the bottom

$meme_setting_markup_20 = [
    'inline_keyboard' => [
        [$set_text_button],
        [$render_button_20],
    ]
];
$meme_setting_markup_20_encoded = json_encode($meme_setting_markup_20);
$meme_setting_markup_21 = [
    'inline_keyboard' => [
        [$set_text_button],
        [$render_button_21],
    ]
];
$meme_setting_markup_21_encoded = json_encode($meme_setting_markup_21);
$meme_setting_markup_22 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_22],
    ]
];
$meme_setting_markup_22_encoded = json_encode($meme_setting_markup_22);
$meme_setting_markup_23 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_23],
    ]
];
$meme_setting_markup_23_encoded = json_encode($meme_setting_markup_23);
$meme_setting_markup_24 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_24],
    ]
];
$meme_setting_markup_24_encoded = json_encode($meme_setting_markup_24);
$meme_setting_markup_25 = [
    'inline_keyboard' => [
        [$set_background_button],
        [$set_text_button],
        [$render_button_25],
    ]
];
$meme_setting_markup_25_encoded = json_encode($meme_setting_markup_25);

//distracted_bf_meme
$set_first_text_button_dbf = [
    'text' => 'First text',
    'callback_data' => 'settext1_dbf',
];

$set_second_text_button_dbf = [
    'text' => 'Second text',
    'callback_data' => 'settext2_dbf',
];

$set_third_text_button_dbf = [
    'text' => 'Third text',
    'callback_data' => 'settext3_dbf',
];
$meme_setting_markup_14 = [
    'inline_keyboard' => [
        [$set_first_text_button_dbf],
        [$set_second_text_button_dbf],
        [$set_third_text_button_dbf],
        [$render_button_14],
    ]
];
$meme_setting_markup_14_encoded = json_encode($meme_setting_markup_14);

//drakepost meme
$set_first_text_button_dp = [
    'text' => 'First text',
    'callback_data' => 'settext1_dp',
];

$set_second_text_button_dp = [
    'text' => 'Second text',
    'callback_data' => 'settext2_dp',
];
$meme_setting_markup_16 = [
    'inline_keyboard' => [
        [$set_first_text_button_dp],
        [$set_second_text_button_dp],
        [$render_button_16],
    ]
];
$meme_setting_markup_16_encoded = json_encode($meme_setting_markup_16);

//exit12 meme
$set_first_text_button_e12 = [
    'text' => 'First text',
    'callback_data' => 'settext1_e12',
];

$set_second_text_button_e12 = [
    'text' => 'Second text',
    'callback_data' => 'settext2_e12',
];

$set_third_text_button_e12 = [
    'text' => 'Third text',
    'callback_data' => 'settext3_e12',
];
$meme_setting_markup_17 = [
    'inline_keyboard' => [
    [$set_first_text_button_e12],
    [$set_second_text_button_e12],
    [$set_third_text_button_e12],
    [$render_button_17]
    ]
];
$meme_setting_markup_17_encoded = json_encode($meme_setting_markup_17);

//hide the pain meme
$set_first_text_button_hdp = [
    'text' => 'First text',
    'callback_data' => 'settext1_hdp',
];

$set_second_text_button_hdp = [
    'text' => 'Second text',
    'callback_data' => 'settext2_hdp',
];
$meme_setting_markup_19 = [
    'inline_keyboard' => [
        [$set_first_text_button_hdp],
        [$set_second_text_button_hdp],
        [$render_button_19],
    ]
];
$meme_setting_markup_19_encoded = json_encode($meme_setting_markup_19);

//two_kitties_talking_meme
$set_first_text_button_tkt = [
    'text' => 'First text',
    'callback_data' => 'settext1_tkt',
];

$set_second_text_button_tkt = [
    'text' => 'Second text',
    'callback_data' => 'settext2_tkt',
];

$set_third_text_button_tkt = [
    'text' => 'Third text',
    'callback_data' => 'settext3_tkt',
];

$set_fourth_text_button_tkt = [
    'text' => 'Fourth text',
    'callback_data' => 'settext4_tkt',
];

$set_fifth_text_button_tkt = [
    'text' => 'Fifth text',
    'callback_data' => 'settext5_tkt',
];

$tkt_meme_setting_markup = [
    'inline_keyboard' =>[
        [$set_background_button],
        [$set_first_text_button_tkt, $set_second_text_button_tkt],
        [$set_third_text_button_tkt, $set_fourth_text_button_tkt],
        [$set_fifth_text_button_tkt],
        [$render_button_1],
    ]
];
$tkt_meme_setting_markup_encoded = json_encode($tkt_meme_setting_markup);