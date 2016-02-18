<?php

use Illuminate\Database\Seeder;
use App\Models\User as User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADMIN USER
       User::create(array(
           'name' => 'Christos',
           'lastname' => 'Dimizas',
           'email' => 'christos.dimizas@gmail.com',
           'password' => Hash::make('1234qwer'),
           'user_role_id' => 1,
           'user_subrole_id' => null,
           'activation_status' => 1,
           'is_deactivated' => 0,
       ));
    }
}
