<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Images::class, function (Faker $faker) {
    return [
        'name' => 'image-item-' . substr(md5(Carbon::now()->toDateTimeString()), 0, 2) . rand(1000, 9999),
        'path' => 'https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_120x44dp.png',
        'event_id' => null,
        'news_id' => null
    ];
});

