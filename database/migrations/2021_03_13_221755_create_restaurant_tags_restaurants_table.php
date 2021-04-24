<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantTagsRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_tags_restaurants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_tag_id');
            $table->unsignedBigInteger('restaurant_id');

            $table->foreign('restaurant_tag_id')->references('id')->on('restaurant_tags')->onDelete('cascade');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurant_tags_restaurants');
    }
}
