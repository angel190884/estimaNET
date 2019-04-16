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
            $table->text('location')->nullable();

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

            $table->integer('type')->default(1);
            
            $table->boolean('active')->default(true);
            $table->boolean('split_catalog')->default(false);

            $table->text('signature_1')->nullable();
            $table->text('signature_2')->nullable();
            $table->text('signature_3')->nullable();
            $table->text('signature_4')->nullable();
            $table->text('signature_5')->nullable();
            $table->text('signature_6')->nullable();

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
