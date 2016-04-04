<?php

use Illuminate\Database\Seeder;


class ReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('benefiter_referrals_lookup')->insert(
            array(
                array('description'   => 'Κοινωνική'),
                array('description'   => 'Ιατρική'),
                array('description'   => 'Νομική'),
                array('description'   => 'Εκπαίδευση/Κατάρτιση'),
                array('description'   => 'Ψυχολόγος')
            )
        );
    }
}
