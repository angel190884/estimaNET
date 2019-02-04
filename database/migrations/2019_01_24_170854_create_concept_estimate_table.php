<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptEstimateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concept_estimate', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('concept_id');
            $table->unsignedInteger('estimate_id');

            $table->foreign('concept_id')->references('id')->on('concepts')->onDelete('cascade');
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');

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
        Schema::dropIfExists('concept_estimate');
    }
}
