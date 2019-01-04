<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('rfc')->unique();
            $table->string('reason_social');
            $table->string('admin_unique');
            $table->string('telephone')->nullable();
            $table->text('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('background')->nullable();
            $table->string('interbank_key')->nullable();
            $table->string('bank_account')->nullable();

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
        Schema::dropIfExists('companies');
    }
}
