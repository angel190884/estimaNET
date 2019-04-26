<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractDeductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_deduction', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('contract_id');
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');

            $table->unsignedInteger('deduction_id');            
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
        Schema::dropIfExists('contract_deduction');
    }
}
