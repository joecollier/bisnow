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

$factory->define(App\Models\Events::class, function (Faker $faker) {
    // $html_paragraph = "";
    // foreach ($paragraphs as $paragraph) {
    //     $html_paragraph .= "<div class='events-item-detail'>{$paragraph}</div>";
    // }

    // $html_paragraphs = "<div id='events-item-details'>{$html_paragraph}</div>";

    // $html = "<div>{$paragraph}</div>";
    // $html = str_replace('. ', '. <br><br>', $html);

    return [
        'name' => 'events-item-' . substr(md5(Carbon::now()->toDateTimeString()), 0, 2) . rand(1000, 9999),
        'description' => $faker->paragraph(2),
    ];
});
