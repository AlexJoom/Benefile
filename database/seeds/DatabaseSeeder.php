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
        $this->call(UsersRolesSeeder::class);
        $this->call(UsersSubrolesSeeder::class);
        $this->call(GendersSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(MaritalStatusSeeder::class);
        $this->call(EducationTableSeeder::class);
        $this->call(LegalStatusTableSeeder::class);
        $this->call(SocialFolderSeeder::class);
        $this->call(MedicalExaminaitonsSeeder::class);
        $this->call(TestUsersTableSeeder::class);
        $this->call(TestBenefitersSeeder::class);


        Model::reguard();
    }
}
