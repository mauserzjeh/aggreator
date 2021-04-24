<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courier_id');
            $table->integer('mon_b')->nullable();
            $table->integer('mon_e')->nullable();
            $table->integer('tue_b')->nullable();
            $table->integer('tue_e')->nullable();
            $table->integer('wed_b')->nullable();
            $table->integer('wed_e')->nullable();
            $table->integer('thu_b')->nullable();
            $table->integer('thu_e')->nullable();
            $table->integer('fri_b')->nullable();
            $table->integer('fri_e')->nullable();
            $table->integer('sat_b')->nullable();
            $table->integer('sat_e')->nullable();
            $table->integer('sun_b')->nullable();
            $table->integer('sun_e')->nullable();
            $table->timestamps();

            $table->foreign('courier_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availabilities');
    }
}
