<?php

use Illuminate\Database\Seeder;


class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('languages')->insert(
            array(
                array('description'   => 'greek'),
                array('description'   => 'english')
            )
        );

        \DB::table('language_levels')->insert(
            array(
                array('description'   => 'Poor'),
                array('description'   => 'Below average'),
                array('description'   => 'Average'),
                array('description'   => 'Good'),
                array('description'   => 'Excellent'),
            )
        );
    }
}
