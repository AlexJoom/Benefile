<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsychosocialSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychosocial_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('social_folder_id')->unsigned();
            $table->date('session_date');
            $table->text('session_comments', 2000);
            $table->integer('psychosocial_theme_id')->unsigned();
            $table->foreign('social_folder_id')->references('id')->on('social_folder');
            $table->foreign('psychosocial_theme_id')->references('id')->on('psychosocial_support_lookup');
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
        Schema::drop('psychosocial_sessions');
    }
}
