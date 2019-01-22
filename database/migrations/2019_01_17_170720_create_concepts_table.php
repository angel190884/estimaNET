<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepts', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger ('contract_id');
            $table->foreign         ('contract_id')->references('id')->on('contracts');

            $table->string          ('code');
            $table->text            ('location');
            $table->text            ('address');
            $table->text            ('name');
            $table->string          ('measurement_unit');
            $table->float           ('quantity',12,6);
            $table->float           ('unit_price',12,6);
            $table->enum            ('type',['N','EXC','EXT'])->default('N');

            $table->boolean         ('immovable')->default(true);
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
        Schema::dropIfExists('concepts');
    }
}
