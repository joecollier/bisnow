<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
     // public function up() {
     //   Schema::create('breeds', function($table) {
     //     $table->increments('id');
     //     $table->string('name');
     //   });
     // }
     // public function down() {
     //   Schema::drop('breeds');
     // }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 64);
            $table->string('html_body', 16383);
            // $table->increments('created_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
