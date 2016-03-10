<?php

use Illuminate\Database\Seeder;

class LegalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('legal_status_lookup')->insert(
            array(
                array('description' => "Απέλαση"),
                array('description' => "Αιτών Άσυλο"),
                array('description' => "Πρόσφυγας"),
                array('description' => "Άδεια Διαμονής"),
                array('description' => "Άδεια Παραμονής"),
                array('description' => 'Ευρωπαίος πολίτης'),
                array('description' => 'Ανθρωπιστικό'),
                array('description' => 'Εκτός νομικού πλαισίου')
            )
        );
    }
}
