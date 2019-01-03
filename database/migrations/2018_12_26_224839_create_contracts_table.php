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
            $table->text('description');

            //MONTOS
            $table->decimal('total', 12, 2);
            $table->decimal('anticipated', 12, 2);
            $table->decimal('extension', 12, 2);
            $table->decimal('adjustment', 12, 2);

            //FECHAS
            $table->date('start');
            $table->date('finish');
            $table->date('signature');
            $table->date('covenant')->nullable();
            $table->date('modified')->nullable();
            
            
            $table->boolean('active');
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
        Schema::dropIfExists('contracts');
    }
}
