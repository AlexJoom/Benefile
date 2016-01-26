<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users_roles')->insert(
            array(
                array('role' => "Διαχειριστής"),
                array('role' => "Γιατρός"),
                array('role' => "Νομικός Σύμβουλος"),
                array('role' => "Κοινωνικός Σύμβουλος"),
                array('role' => "Ψυχολόγος")
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
