<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('language_lookup')->insert(
            array(
                array('language' => "Ελληνικά"),
                array('language' => "Αγγλικά"),
                array('language' => "Αριθμός Δελτίου Πρόσφυγα"),
                array('language' => "Γαλλικά"),
                array('language' => "Αραβικά"),
                array('language' => 'Φαρσί'),
                array('language' => 'Άλλο')
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
