<?php

use Illuminate\Database\Seeder;

class EducationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('education_lookup')->insert(
            array(
                array('education_title' => "Αναλφάβητος"),
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
}
