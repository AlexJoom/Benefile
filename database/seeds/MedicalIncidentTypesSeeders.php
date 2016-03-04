<?php

use Illuminate\Database\Seeder;

class MedicalIncidentTypesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('medical_incident_type_lookup')->insert(
            array(
                array('description' => "Αντιμετώπιση στο ιατρείο"),
                array('description' => "Δόθηκαν συστάσεις"),
                array('description' => "Παραπομπή για διαγνωστικές"),
                array('description' => "Παραπομπή σε ειδικευμένο γιατρό"),
            )
        );
    }
}
