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
                array('legal_status_title' => "Διοικητική απόφαση απέλασης"),
                array('legal_status_title' => "Αριθμός Δελτίου αιτήσαντος ασύλου"),
                array('legal_status_title' => "Αριθμός Δελτίου Πρόσφυγα"),
                array('legal_status_title' => "Βεβαίωση άδειας διαμονής (Χρόνος/Λήξη)"),
                array('legal_status_title' => "Άδεια παραμονής (μετανάστη)"),
                array('legal_status_title' => 'Ευρωπαίος πολίτης'),
                array('legal_status_title' => 'Εκτός νομικού πλαισίου')
            )
        );
    }
}
