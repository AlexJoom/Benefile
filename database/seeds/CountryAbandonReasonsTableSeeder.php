<?php

use Illuminate\Database\Seeder;

class CountryAbandonReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('country_abandon_reasons_lookup')->insert(
            array(
                array('description' => 'Κοινωνικός'),
                array('description' => 'Πολιτικός'),
                array('description' => 'Οικονομικός'),
                array('description' => 'Φυλετικός'),
                array('description' => 'Λόγω Φύλου'),
                array('description' => 'Άλλο'),
            )
        );
    }
}
