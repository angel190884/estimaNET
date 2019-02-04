<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneratorLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generator_location', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('location_id');
            $table->unsignedInteger('generator_id');

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('generator_id')->references('id')->on('concept_estimate')->onDelete('cascade');

            $table->float('quantity',12,6);

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
        Schema::dropIfExists('generator_location');
    }
}
