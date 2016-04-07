<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // create the lookups needed for legal_folder table creation
        Schema::create('legal_folder_status_lookup', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
        });

        Schema::create('penalty_lookup', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
        });

        // create legal_folder table
        Schema::create('legal_folder', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('legal_folder_status_id')->unsigned();
            $table->integer('penalty_id')->unsigned();
            $table->text('penalty_text')->nullable();
            $table->integer('benefiter_id')->unsigned();
            $table->foreign('benefiter_id')->references('id')->on('benefiters');
            $table->foreign('legal_folder_status_id')->references('id')->on('legal_folder_status_lookup');
            $table->foreign('penalty_id')->references('id')->on('penalty_lookup');
            $table->timestamps();
        });

        // create the lookups needed for asylum_request table creation
        Schema::create('procedure_lookup', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
        });

        Schema::create('request_status_lookup', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
        });

        // create asylum_request table
        Schema::create('asylum_request', function(Blueprint $table){
            $table->increments('id');
            $table->date('request_date');
            $table->integer('procedure_id')->unsigned();
            $table->integer('request_status_id')->unsigned()->nullable();
            $table->text('request_progress')->nullable();
            $table->integer('legal_folder_id')->unsigned();
            $table->foreign('procedure_id')->references('id')->on('procedure_lookup');
            $table->foreign('request_status_id')->references('id')->on('request_status_lookup');
            $table->foreign('legal_folder_id')->references('id')->on('legal_folder');
            $table->timestamps();
        });

        Schema::create('action_lookup', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
        });

        Schema::create('result_lookup', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
        });

        // create no_legal_status table
        Schema::create('legal_section_status', function(Blueprint $table){
            $table->increments('id');
            $table->integer('legal_option_id')->unsigned();
            $table->integer('action_id')->unsigned();
            $table->integer('result_id')->unsigned()->nullable();
            $table->integer('legal_folder_id')->unsigned();
            $table->foreign('legal_option_id')->references('id')->on('legal_folder_status_lookup');
            $table->foreign('action_id')->references('id')->on('action_lookup');
            $table->foreign('result_id')->references('id')->on('result_lookup');
            $table->foreign('legal_folder_id')->references('id')->on('legal_folder');
            $table->timestamps();
        });

        // create the lookup needed for legal_lawyer_action table creation
        Schema::create('lawyer_action_lookup', function(Blueprint $table){
            $table->increments('id');
            $table->string('description');
        });

        // create legal_lawyer_action table
        Schema::create('legal_lawyer_action', function(Blueprint $table){
            $table->increments('id');
            $table->integer('lawyer_action_id')->unsigned();
            $table->integer('legal_folder_id')->unsigned();
            $table->foreign('lawyer_action_id')->references('id')->on('lawyer_action_lookup');
            $table->foreign('legal_folder_id')->references('id')->on('legal_folder');
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
        Schema::drop('legal_lawyer_action');
        Schema::drop('lawyer_action_lookup');
        Schema::drop('legal_section_status');
        Schema::drop('result_lookup');
        Schema::drop('action_lookup');
        Schema::drop('asylum_request');
        Schema::drop('request_status_lookup');
        Schema::drop('procedure_lookup');
        Schema::drop('legal_folder');
        Schema::drop('penalty_lookup');
        Schema::drop('legal_folder_status_lookup');
    }
}
