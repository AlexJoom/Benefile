<?php

use Illuminate\Database\Seeder;

class WorkTitleListLookupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('work_title_list_lookup')->insert(
            array(
                array('work_title' => "Εργάτης"),
            )
        );
    }
}
