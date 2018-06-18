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

$factory->define(App\Models\News::class, function (Faker $faker) {
    $paragraphs = $faker->paragraphs(3);

    $html_paragraph = "";
    foreach ($paragraphs as $paragraph) {
        $html_paragraph .= "<div class='news-item-detail'>{$paragraph}</div>";
    }

    $html_paragraphs = "<div>{$html_paragraph}</div>";

    // $html = "<div>{$paragraph}</div>";
    // $html = str_replace('. ', '. <br><br>', $html);

    return [
        'title' => 'news-item-' . substr(md5(Carbon::now()->toDateTimeString()), 0, 2) . rand(1000, 9999),
        'html_body' => $html_paragraphs,
    ];
});
