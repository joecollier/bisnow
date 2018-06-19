<?php

use App\Models\News;
use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Images::class, 3)->create()->each(function ($images) {});
    }
}
