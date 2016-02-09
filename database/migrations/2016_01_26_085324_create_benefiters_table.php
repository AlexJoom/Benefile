<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBenefitersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benefiters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('folder_number');
            $table->string('name');
            $table->string('lastname');
            $table->string('fathers_name');
            $table->string('mothers_name');
            $table->date('birth_date');
            $table->date('arrival_date');
            $table->string('address');
            $table->integer('telephone')->unsigned();
            $table->integer('number_of_children')->unsigned()->nullable();
            $table->string('relatives_residence')->nullable();
            $table->string('legal_status_details')->nullable();
            $table->date('legal_status_exp_date');
            $table->string('other_language')->nullable();
            $table->boolean('language_interpreter_needed');
            // $table->foreign('language_interpreter_needed_id')->references('id')->on('yes_or_no_lookup');
            $table->boolean('is_benefiter_working')->nullable();
            //$table->foreign('work_status_id')->references('id')->on('yes_or_no_lookup');        // FOREIGN KEY
            $table->boolean('working_legally')->nullable();
            //$table->foreign('work_legal_type_id')->references('id')->on('work_legal_type_lookup');
            $table->string('country_abandon_reason')->nullable();
            $table->string('travel_route')->nullable();
            $table->string('travel_duration')->nullable();
            $table->string('detention_duration')->nullable();
            $table->integer('has_social_reference')->nullable();
            //$table->foreign('social_reference_id')->references('id')->on('yes_or_no_lookup');
            $table->string('social_reference_actions');
            $table->date('social_reference_date');
            $table->boolean('has_medical_reference');
            //$table->foreign('medical_reference_id')->references('id')->on('yes_or_no_lookup');
            $table->string('medical_reference_actions');
            $table->date('medical_reference_date');
            $table->boolean('has_legal_reference');
            //$table->foreign('legal_reference_id')->references('id')->on('yes_or_no_lookup');
            $table->string('legal_reference_actions');
            $table->date('legal_reference_date');
            $table->boolean('has_educational_reference');
            //$table->foreign('educational_reference_id')->references('id')->on('yes_or_no_lookup');
            $table->string('educational_reference_actions');
            $table->date('educational_reference_date');
            $table->string('social_history');
            $table->timestamps();

            // Foreign keys
            $table->integer('gender_id')->unsigned()->nullable();
            $table->foreign('gender_id')->references('id')->on('genders_lookup');
            $table->integer('origin_country_id')->unsigned()->nullable();
            $table->foreign('origin_country_id')->references('id')->on('countries_lookup');
            $table->integer('nationality_country_id')->unsigned()->nullable();
            $table->foreign('nationality_country_id')->references('id')->on('countries_lookup');
            $table->integer('marital_status_id')->unsigned()->nullable();
            $table->foreign('marital_status_id')->references('id')->on('marital_status_lookup');
            $table->integer('legal_status_id')->unsigned()->nullable();
            $table->foreign('legal_status_id')->references('id')->on('legal_status_lookup');
            $table->integer('education_id')->unsigned()->nullable();
            $table->foreign('education_id')->references('id')->on('education_lookup');
            $table->integer('work_title_id')->unsigned()->nullable();
            $table->foreign('work_title_id')->references('id')->on('work_title_list_lookup');
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
        });

        Schema::create('language_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
        });

        Schema::create('benefiters_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('benefiter_id')->unsigned();
            $table->foreign('benefiter_id')->references('id')->on('benefiters');
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->integer('language_level_id')->unsigned();
            $table->foreign('language_level_id')->references('id')->on('language_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benefiters_languages');
        Schema::dropIfExists('language_levels');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('benefiters');
    }
}
