<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeductionEstimateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deduction_estimate', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('estimate_id');
            $table->unsignedInteger('deduction_id');

            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
            $table->foreign('deduction_id')->references('id')->on('deductions')->onDelete('cascade');

            $table->float('factor')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deduction_estimate');
    }
}
