<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 127);
            $table->text('description');
            $table->string('address', 255);
            $table->string('latitude', 24);
            $table->string('longitude', 24);
            $table->string('phone', 50);
            $table->timestamps();
            
            $table->unsignedInteger('shop_category_id');
            $table->foreign('shop_category_id')->references('id')->on('shop_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('restaurants');
    }
}
