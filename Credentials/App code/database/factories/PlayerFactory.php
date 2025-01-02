<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Player;
use Faker\Generator as Faker;
$factory->define(Player::class, function (Faker $faker) {
    static $level = 0;
    return [
        'wallet_address' => Str::random(30),
        'balance' => 0,
        'alias' => Str::random(30),
        'power' => 0,
        'color_id' => 0,
        'room_openn_flag' => 0,
        'money' => 0,
        'wins' => 0,
        'nft_1_sunflower_1' => 0,
        'nft_2_jungle_1' => 0,
        'nft_2_jungle_mega' => 0,
        'nft_2_jungle_1_base' => 0,
        'nft_2_jungle_1_polygon' => 0,
        'nft_3_battery' => 0,
        'nft_4_color1' => 0,
        'nft_5_color2' => 0,
        'nft_6_color3' => 0,
        'nft_7_color4' => 0,
        'nft_8_bot' => 0,
        'nft_21_raygun' => 0,
        'nft_9_cat' => 0,
        'nft_10_monkey' => 0,
        'nft_11_punks' => 0,
        'nft_12_monster' => 0,
        'nft_13_doodle' => 0,
        'nft_14_sandbox' => 0,
        'nft_15_totem' => 0,
        'nft_16_nike' => 0,
        'nft_17_adidas' => 0,
        'nft_18_pepsi' => 0,
        'nft_19_lacoste' => 0,
        'nft_20_land' => 0,
        'nft_22_leo_1' => 0,
        'nft_23_leo_2' => 0,
        'nft_24_leo_3' => 0,
        'nft_25_wb' => 0,
    ];
});
