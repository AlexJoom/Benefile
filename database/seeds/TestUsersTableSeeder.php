<?php

use Illuminate\Database\Seeder;
use App\Models\User as User;

class TestUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // TEST USERS (WAIT TO BE ACTIVE)
        User::create(array(
            'name' => 'Doctor_Name_1',
            'lastname' => 'DoctorLastname_1',
            'email' => 'chris.tosdimi.z.a.s@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 2,
            'user_subrole_id' => 3,
            'activation_status' => 0,
            'is_deactivated' => 0,
        ));

        User::create(array(
            'name' => 'Legal_Adv_Name_2',
            'lastname' => 'Legal_Adv_Lastname_2',
            'email' => 'ch.ris.tosdimizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 3,
            'user_subrole_id' => null,
            'activation_status' => 0,
            'is_deactivated' => 0,
        ));

        User::create(array(
            'name' => 'Social_Adv_Name_3',
            'lastname' => 'Social_Adv_Lastname_3',
            'email' => 'chr.ist.osdimizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 4,
            'user_subrole_id' => null,
            'activation_status' => 0,
            'is_deactivated' => 0,
        ));

        User::create(array(
            'name' => 'Psycho_Name_4',
            'lastname' => 'Psycho_Lastname_4',
            'email' => 'chri.sto.sdimizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 5,
            'user_subrole_id' => null,
            'activation_status' => 0,
            'is_deactivated' => 0,
        ));


        //---------------------------------------------------------------


        // TEST USERS (ACTIVE)
        User::create(array(
            'name' => 'Doctor_Name_1',
            'lastname' => 'DoctorLastname_1',
            'email' => 'christosdimizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 2,
            'user_subrole_id' => 8,
            'activation_status' => 1,
            'is_deactivated' => 0,
        ));

        User::create(array(
            'name' => 'Legal_Adv_Name_2',
            'lastname' => 'Legal_Adv_Lastname_2',
            'email' => 'ch.ristosdimizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 3,
            'user_subrole_id' => null,
            'activation_status' => 1,
            'is_deactivated' => 0,
        ));

        User::create(array(
            'name' => 'Social_Adv_Name_3',
            'lastname' => 'Social_Adv_Lastname_3',
            'email' => 'chr.istosdimizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 4,
            'user_subrole_id' => null,
            'activation_status' => 1,
            'is_deactivated' => 0,
        ));

        User::create(array(
            'name' => 'Psycho_Name_4',
            'lastname' => 'Psycho_Lastname_4',
            'email' => 'chri.stosdimizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 5,
            'user_subrole_id' => null,
            'activation_status' => 1,
            'is_deactivated' => 0,
        ));

        // ----------------------------------------------


        // TEST USERS (DEACTIVATED)
        User::create(array(
            'name' => 'Doctor_Name_1',
            'lastname' => 'DoctorLastname_1',
            'email' => 'chris.to.sdimizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 2,
            'user_subrole_id' => 6,
            'activation_status' => 0,
            'is_deactivated' => 1,
        ));

        User::create(array(
            'name' => 'Legal_Adv_Name_2',
            'lastname' => 'Legal_Adv_Lastname_2',
            'email' => 'ch.ris.tos.dimizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 3,
            'user_subrole_id' => null,
            'activation_status' => 0,
            'is_deactivated' => 1,
        ));

        User::create(array(
            'name' => 'Social_Adv_Name_3',
            'lastname' => 'Social_Adv_Lastname_3',
            'email' => 'chr.ist.osd.imizas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 4,
            'user_subrole_id' => null,
            'activation_status' => 0,
            'is_deactivated' => 1,
        ));

        User::create(array(
            'name' => 'Psycho_Name_4',
            'lastname' => 'Psycho_Lastname_4',
            'email' => 'chri.sto.sdim.izas@gmail.com',
            'password' => Hash::make('1234qwer'),
            'user_role_id' => 5,
            'user_subrole_id' => null,
            'activation_status' => 0,
            'is_deactivated' => 1,
        ));
    }
}
