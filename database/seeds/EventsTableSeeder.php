<?php

use App\Models\Events;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Events::class, 6)->create()->each(function ($events) {});
    }
}
