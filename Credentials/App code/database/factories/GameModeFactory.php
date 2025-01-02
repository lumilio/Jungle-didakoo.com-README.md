<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\GameMode;
use Faker\Generator as Faker;
$factory->define(GameMode::class, function (Faker $faker) {
    static $level = 0;
    return [
        'level' => $level++,
        'active' => $level - 1 == 0
    ];
});
