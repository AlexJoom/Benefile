<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        // $this->call(UsersRolesSeeder::class);
        // $this->call(UsersSubrolesSeeder::class);
        // $this->call(GendersTableSeeder::class);
        // $this->call(MaritalStatusSeeder::class);
        // $this->call(EducationTableSeeder::class);
        // $this->call(LegalStatusSeeder::class);

        Model::reguard();
    }
}
