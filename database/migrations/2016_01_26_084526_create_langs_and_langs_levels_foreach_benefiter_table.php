<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLangsAndLangsLevelsForeachBenefiterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefiters_langs_and_langs_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('benefiter_id');
            $table->integer('lang_id');
            $table->integer('language_level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benefiters_langs_and_langs_levels');
    }
}
