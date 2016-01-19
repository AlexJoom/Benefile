<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedMaritalStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('marital_status_lookup')->insert(
            array(
                array('marital_status_title' => "Άγαμος"),
                array('marital_status_title' => "Έγγαμος"),
                array('marital_status_title' => "Διαζευγμένος/η"),
                array('marital_status_title' => "Χήρος/α"),
                array('marital_status_title' => "Εν διαστάση")
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
