<?php

use Illuminate\Database\Seeder;

class MedicalLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('medical_location_lookup')->insert(
            array(
                array('description' => "Κέντρο κράτησης Κορίνθου"),
                array('description' => "Πολυιατρείο Αθήνας"),
                array('description' => "Πολυιατρείο Θεσσαλονίκης"),
                array('description' => "Κέντρο Ημέρας Αθήνας"),
                array('description' => "Κέντρο Ημέρας"),
            )
        );
    }
}
