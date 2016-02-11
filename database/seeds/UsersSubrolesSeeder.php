<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Seeder;

class UsersSubrolesSeeder extends Seeder
{

    public function run()
    {
        \DB::table('users_subroles')->insert(
            array(
                array('subrole' => "Γενικός ιατρός"),
                array('subrole' => "Παιδίατρος"),
                array('subrole' => "Γυναικολόγος"),
                array('subrole' => "Κοινωνικός Σύμβουλος"),
                array('subrole' => "Ψυχολόγος"),
                array('subrole'  => 'Οδοντίατρος'),
                array('subrole'  => 'Δερματολόγος'),
                array('subrole'  => 'Ορθοπεδικός'),
                array('subrole'  => 'Καρδιολόγος'),
                array('subrole'  => 'Οφθαλμίατρος'),
                array('subrole'  => 'Ψυχίατρος'),
                array('subrole'  => 'Νευρολόγος'),
            )
        );
    }
}
