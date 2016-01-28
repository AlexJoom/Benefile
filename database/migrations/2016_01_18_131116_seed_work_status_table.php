<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedWorkStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('work_status_lookup')->insert(
            array(
                array('work_status' => "Ναι"),
                array('work_status' => "Όχι"),
                array('work_status' => "Νόμιμη"),
                array('work_status' => "Παράνομη")
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
