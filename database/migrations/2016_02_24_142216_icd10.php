<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Icd10 extends Migration
{
    public function up()
    {
        Schema::create('icd10', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->text('description', 2000);
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
        Schema::drop('ICD10_conditions');
    }
}
