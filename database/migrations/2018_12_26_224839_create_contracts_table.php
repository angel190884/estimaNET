<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->text('name');
            $table->string('short_name')->nullable();
            $table->text('description')->nullable();

            //MONTOS
            $table->float('amount_total', 15, 2);
            $table->float('amount_anticipated', 15, 2)->nullable();
            $table->float('amount_extension', 15, 2)->nullable();
            $table->float('amount_adjustment', 15, 2)->nullable();

            //FECHAS
            $table->date('date_start');
            $table->date('date_finish');
            $table->date('date_signature')->nullable();
            $table->date('date_signature_covenant')->nullable();
            $table->date('date_finish_modified')->nullable();
            
            
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('contracts');
    }
}
