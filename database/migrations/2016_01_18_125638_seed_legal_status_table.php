<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedLegalStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('legal_status_lookup')->insert(
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
