<?php

Use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class UsersRolesSeeder extends Seeder
{
    public function run()
    {
        \DB::table('users_roles')->insert(
            array(
                array('role' => "Διαχειριστής"),
                array('role' => "Γιατρός"),
                array('role' => "Νομικός Σύμβουλος"),
                array('role' => "Κοινωνικός Σύμβουλος"),
                array('role' => "Ψυχολόγος")
            )
        );
    }

}
