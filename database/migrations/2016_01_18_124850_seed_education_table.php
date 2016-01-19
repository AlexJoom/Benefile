<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('education_lookup')->insert(
            array(
                array('education_title' => "Αναλφάλβητος"),
                array('education_title' => "Δημοτικό"),
                array('education_title' => "Γυμνάσιο"),
                array('education_title' => "Λύκειο"),
                array('education_title' => "Επαγγελματικό Λύκειο"),
                array('education_title' => "ΤΕΙ"),
                array('education_title' => "ΑΕΙ"),
                array('education_title' => "Μεταπτυχιακός τίτλος"),
                array('education_title' => "Διδακτορικός τίτλος")
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
