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

            $table->integer('gender_id')->unsigned();
            $table->foreign('gender_id')->references('id')->on('genders_lookup');                // FOREIGN KEY

            $table->integer('origin_country_id')->unsigned();
            $table->foreign('origin_country_id')->references('id')->on('countries_lookup');       // FOREIGN KEY

            $table->integer('nationality_country_id')->unsigned();
            $table->foreign('nationality_country_id')->references('id')->on('countries_lookup');  // FOREIGN KEY

            $table->date('birth_date');

            $table->date('arrival_date');

            $table->string('address');

            $table->integer('telephone')->unsigned();

            $table->integer('marital_status_id')->unsigned();
            $table->foreign('marital_status_id')->references('id')->on('marital_status_lookup');  // FOREIGN KEY

            $table->integer('number_of_children')->unsigned();

            $table->string('relatives_residence');

            $table->integer('legal_status_id')->unsigned();
            $table->foreign('legal_status_id')->references('id')->on('legal_status_lookup');      // FOREIGN KEY

            $table->string('legal_status_details');

            $table->date('legal_status_exp_date');

            $table->integer('education_id')->unsigned();
            $table->foreign('education_id')->references('id')->on('education_lookup');            // FOREIGN KEY

            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('language_lookup');              // FOREIGN KEY

            $table->integer('language_level_id')->unsigned();
            $table->foreign('language_level_id')->references('id')->on('language_level_lookup');  // FOREIGN KEY

            $table->string('other_language');

            $table->integer('work_type_id')->unsigned();
            $table->foreign('work_type_id')->references('id')->on('work_type_list_lookup');       // FOREIGN KEY

            $table->integer('work_status_id')->unsigned();
            $table->foreign('work_status_id')->references('id')->on('work_status_lookup');        // FOREIGN KEY

            $table->string('country_abandon_reason');

            $table->string('travel_route');

            $table->string('travel_duration');

            $table->string('detention_duration');

            $table->integer('social_reference_id')->unsigned();
            $table->foreign('social_reference_id')->references('id')->on('reference_lookup');       // FOREIGN KEY
            $table->string('social_reference_actions');
            $table->date('social_reference_date');

            $table->integer('medical_reference_id')->unsigned();
            $table->foreign('medical_reference_id')->references('id')->on('reference_lookup');       // FOREIGN KEY
            $table->string('medical_reference_actions');
            $table->date('medical_reference_date');

            $table->integer('legal_reference_id')->unsigned();
            $table->foreign('legal_reference_id')->references('id')->on('reference_lookup');       // FOREIGN KEY
            $table->string('legal_reference_actions');
            $table->date('legal_reference_date');

            $table->integer('educational_reference_id')->unsigned();
            $table->foreign('educational_reference_id')->references('id')->on('reference_lookup');       // FOREIGN KEY
            $table->string('educational_reference_actions');
            $table->date('educational_reference_date');

            $table->string('social_history');

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
        Schema::dropIfExists('benefiters');
    }
}
