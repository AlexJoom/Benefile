<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GendersSeeder extends Seeder
{
    public function run()
    {
        \DB::table('genders_lookup')->insert(
          array(
              array('gender' => "Άντρας"),
              array('gender' => "Γυναίκα"),
              array('gender' => "Άλλο")
          )
        );
    }
}
