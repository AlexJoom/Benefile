<?php

use Illuminate\Database\Seeder;

class LegalFolderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('legal_folder_status_lookup')->insert(
            array(
                array('description' => 'Αίτημα ασύλου'),
                array('description' => 'Εκτός νομικού πλαισίου'),
            )
        );

        \DB::table('penalty_lookup')->insert(
            array(
                array('description' => 'Ναι'),
                array('description' => 'Όχι'),
            )
        );

        \DB::table('procedure_lookup')->insert(
            array(
                array('description' => 'Παλιά Διαδικασία'),
                array('description' => 'Νέα Διαδικασία'),
            )
        );

        \DB::table('request_status_lookup')->insert(
            array(
                array('description' => 'α\''),
                array('description' => 'β\''),
                array('description' => 'μεταγενέστερο'),
            )
        );

        \DB::table('legal_section_options_lookup')->insert(
            array(
                array('description' => 'Αίτημα Ασύλου'),
                array('description' => 'Εκτός Νομικού Πλαισίου'),
                array('description' => 'Αρ. Δελτίου Αιτήσαντος Ασύλου'),
                array('description' => 'Αρ. Δελτίου Πρόσφυγα'),
                array('description' => 'Βεβ. Άδειας Διαμονής'),
                array('description' => 'Άδεια Παραμονής'),
                array('description' => 'Ευρωπαϊος Πολίτης'),
                array('description' => 'Ασυνόδευτος Ανήλικος'),
            )
        );

        \DB::table('action_lookup')->insert(
            array(
                array('description' => 'Μη περαιτέρω ενέργειες'),
                array('description' => 'Αντιρρήσεις κατά την κράτηση'),
            )
        );

        \DB::table('result_lookup')->insert(
            array(
                array('description' => 'θετικό'),
                array('description' => 'αρνητικό'),
            )
        );

        \DB::table('lawyer_action_lookup')->insert(
            array(
                array('description' => 'Ενημέρωση δικαιωμάτων'),
                array('description' => 'Ενημέρωση για διαδικασία ασύλου'),
                array('description' => 'Προετοιμασία για συνέντευξη'),
                array('description' => 'Προσφυγή'),
                array('description' => 'Διαδικασία για άρση κράτησης'),
            )
        );
    }
}
