<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileImportSchemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('File_Import_Schema', function (Blueprint $table) {
            $table->increments('id');

            $table->string('folder_number');

            $table->string('name');

            $table->string('lastname');

            $table->string('fathers_name');

            $table->string('mothers_name');

            $table->string('gender');

            $table->string('origin_country');

            $table->string('nationality_country');

            $table->string('birth_date');

            $table->string('arrival_date');

            $table->string('address');

            $table->string('telephone');

            $table->string('marital_status');

            $table->string('number_of_children');

            $table->string('relatives_residence');

            $table->string('legal_status');

            $table->string('legal_status_details');

            $table->string('legal_status_exp_date');

            $table->string('education');

            $table->string('language');
            $table->string('language_level');
            $table->string('other_language');
            $table->string('language_interpreter_needed');

            $table->string('is_benefiter_working');
            $table->string('work_title');
            $table->string('working_legally');


            $table->string('country_abandon_reason');

            $table->string('travel_route');

            $table->string('travel_duration');

            $table->string('detention_duration');

            $table->string('has_social_reference');
            $table->string('social_reference_actions');
            $table->string('social_reference_date');

            $table->string('has_medical_reference');
            $table->string('medical_reference_actions');
            $table->string('medical_reference_date');

            $table->string('has_legal_reference');
            $table->string('legal_reference_actions');
            $table->string('legal_reference_date');

            $table->string('has_educational_reference');
            $table->string('educational_reference_actions');
            $table->string('educational_reference_date');

            $table->string('social_history');

            $table->timestamps();

        });

        // Basic import info table
        Schema::create('import_csv_basic_info', function(Blueprint $table){
            $table->increments('id');
            $table->string('csv_name')->nullable();
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
        Schema::dropIfExists('File_Import_Schema');
    }
}
