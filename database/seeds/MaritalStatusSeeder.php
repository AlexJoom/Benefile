<?php

use Illuminate\Database\Seeder;

class MaritalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('marital_status_lookup')->insert(
            array(
                array('marital_status_title' => "Άγαμος"),
                array('marital_status_title' => "Έγγαμος"),
                array('marital_status_title' => "Διαζευγμένος"),
                array('marital_status_title' => "Χήρος"),
                array('marital_status_title' => "Εν διαστάσει")
            )
        );
    }
}
