<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_folder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('benefiter_id')->unsigned();
            $table->string('ethnic_group')->nullable();
            $table->text('comments', 2000)->nullable();
            $table->foreign('benefiter_id')->references('id')->on('benefiters');
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
        Schema::drop('social_folder');
    }
}
