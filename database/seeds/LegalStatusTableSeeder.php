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
                array('description' => "Διοικητική απόφαση απέλασης"),
                array('description' => "Αριθμός Δελτίου αιτήσαντος ασύλου"),
                array('description' => "Αριθμός Δελτίου Πρόσφυγα"),
                array('description' => "Βεβαίωση άδειας διαμονής (Χρόνος/Λήξη)"),
                array('description' => "Άδεια παραμονής (μετανάστη)"),
                array('description' => 'Ευρωπαίος πολίτης'),
                array('description' => 'Εκτός νομικού πλαισίου')
            )
        );
    }
}
