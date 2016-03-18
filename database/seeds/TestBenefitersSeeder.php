<?php

use App\Models\Benefiters_Tables_Models\Benefiter as Benefiter;
use Illuminate\Database\Seeder;

class TestBenefitersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('binary_lookup')->insert(
            array(
                array(
                    'id' => 0,
                    'description' => 'όχι',
                ),
                array(
                    'id' => 1,
                    'description' => 'ναι',
                ),
            )
        );

        \DB::table('working_legally_lookup')->insert(
            array(
                array('description' => 'Νόμιμη'),
                array('description' => 'Παράνομη'),
            )
        );

        Benefiter::create(array(
                'folder_number'                 => 'KK1',
                'name'                          => 'Ben-name-1',
                'lastname'                      => 'Ben-lastname-1',
                'fathers_name'                  => 'Bens-father-1',
                'mothers_name'                  => 'Bens-mother-1',
                'birth_date'                    => date('2014-03-15'),
                'arrival_date'                  => date('2014-03-15'),
                'address'                       => 'address-1',
                'telephone'                     => '123456789',
                'number_of_children'            => '12',
                'relatives_residence'           => 'relatives residence-1',

//                'other_language'                => '',
                'language_interpreter_needed'   => 0,
                'is_benefiter_working'          => 1,
//                'legal_status_details'          => 'legal details',
                'working_legally'               => 1,
                'country_abandon_reason'        => 'country abandon reason',
                'travel_route'                  => 'travel route',
                'travel_duration'               => '2 weeks',
                'detention_duration'            => '',

//                'has_educational_reference'     => 1,
//                'educational_reference_actions' => 'education',
//                'educational_reference_date'    => date('2014-03-15'),

                'origin_country'                => 'origin country',
                'nationality_country'           => 'nationality country',
                'gender_id'                     => 1,
                'marital_status_id'             => 1,
                'education_id'                  => 1,
                'work_title_id'                 => 1
        ));

        Benefiter::create(array(
            'folder_number'                 => 'KK2',
            'name'                          => 'Ben-name-2',
            'lastname'                      => 'Ben-lastname-2',
            'fathers_name'                  => 'Bens-father-2',
            'mothers_name'                  => 'Bens-mother-2',
            'birth_date'                    => date('2014-03-15'),
            'arrival_date'                  => date('2014-03-15'),
            'address'                       => 'address-2',
            'telephone'                     => '123456789',
            'number_of_children'            => '12',
            'relatives_residence'           => 'relatives residence-2',

//            'other_language'                => '',
            'language_interpreter_needed'   => 0,
            'is_benefiter_working'          => 1,
//            'legal_status_details'          => 'legal details',
            'working_legally'               => 1,
            'country_abandon_reason'        => 'country abandon reason',
            'travel_route'                  => 'travel route',
            'travel_duration'               => '2 weeks',
            'detention_duration'            => '',

//            'has_educational_reference'     => 2,
//            'educational_reference_actions' => 'education',
//            'educational_reference_date'    => date('2014-03-15'),

            'origin_country'                => 'origin country',
            'nationality_country'           => 'nationality country',
            'gender_id'                     => 2,
            'marital_status_id'             => 1,
            'education_id'                  => 4,
            'work_title_id'                 => 1
        ));

        Benefiter::create(array(
            'folder_number'                 => 'KK3',
            'name'                          => 'Ben-name-1',
            'lastname'                      => 'Ben-lastname-1',
            'fathers_name'                  => 'Bens-father-1',
            'mothers_name'                  => 'Bens-mother-1',
            'birth_date'                    => date('2014-03-15'),
            'arrival_date'                  => date('2014-03-15'),
            'address'                       => 'address-1',
            'telephone'                     => '123456789',
            'number_of_children'            => '12',
            'relatives_residence'           => 'relatives residence-1',

//            'other_language'                => '',
            'language_interpreter_needed'   => 0,
            'is_benefiter_working'          => 1,
//            'legal_status_details'          => 'legal details',
            'working_legally'               => 1,
            'country_abandon_reason'        => 'country abandon reason',
            'travel_route'                  => 'travel route',
            'travel_duration'               => '2 weeks',
            'detention_duration'            => '',

//            'has_educational_reference'     => 3,
//            'educational_reference_actions' => 'education',
//            'educational_reference_date'    => date('2014-03-15'),

            'origin_country'                => 'origin country',
            'nationality_country'           => 'nationality country',
            'gender_id'                     => 3,
            'marital_status_id'             => 1,
            'education_id'                  => 6,
            'work_title_id'                 => 1
        ));

        Benefiter::create(array(
            'folder_number'                 => 'KK4',
            'name'                          => 'Ben-name-3',
            'lastname'                      => 'Ben-lastname-3',
            'fathers_name'                  => 'Bens-father-3',
            'mothers_name'                  => 'Bens-mother-3',
            'birth_date'                    => date('2014-03-15'),
            'arrival_date'                  => date('2014-03-15'),
            'address'                       => 'address-3',
            'telephone'                     => '123456789',
            'number_of_children'            => '12',
            'relatives_residence'           => 'relatives residence-3',

//            'other_language'                => '',
            'language_interpreter_needed'   => 0,
            'is_benefiter_working'          => 1,
//            'legal_status_details'          => 'legal details',
            'working_legally'               => 1,
            'country_abandon_reason'        => 'country abandon reason',
            'travel_route'                  => 'travel route',
            'travel_duration'               => '2 weeks',
            'detention_duration'            => '',

//            'has_educational_reference'     => 4,
//            'educational_reference_actions' => 'education',
//            'educational_reference_date'    => date('2014-03-15'),

            'origin_country'                => 'origin country',
            'nationality_country'           => 'nationality country',
            'gender_id'                     => 1,
            'marital_status_id'             => 1,
            'education_id'                  => 2,
            'work_title_id'                 => 1
        ));

        Benefiter::create(array(
            'folder_number'                 => 'KK5',
            'name'                          => 'Ben-name-4',
            'lastname'                      => 'Ben-lastname-4',
            'fathers_name'                  => 'Bens-father-4',
            'mothers_name'                  => 'Bens-mother-4',
            'birth_date'                    => date('2014-03-15'),
            'arrival_date'                  => date('2014-03-15'),
            'address'                       => 'address-4',
            'telephone'                     => '123456789',
            'number_of_children'            => '12',
            'relatives_residence'           => 'relatives residence-4',

//            'other_language'                => '',
            'language_interpreter_needed'   => 0,
            'is_benefiter_working'          => 1,
//            'legal_status_details'          => 'legal details',
            'working_legally'               => 1,
            'country_abandon_reason'        => 'country abandon reason',
            'travel_route'                  => 'travel route',
            'travel_duration'               => '2 weeks',
            'detention_duration'            => '',

//            'has_educational_reference'     => 5,
//            'educational_reference_actions' => 'education',
//            'educational_reference_date'    => date('2014-03-15'),

            'origin_country'                => 'origin country',
            'nationality_country'           => 'nationality country',
            'gender_id'                     => 3,
            'marital_status_id'             => 1,
            'education_id'                  => 5,
            'work_title_id'                 => 1
        ));

        Benefiter::create(array(
            'folder_number'                 => 'KK6',
            'name'                          => 'Ben-name-5',
            'lastname'                      => 'Ben-lastname-5',
            'fathers_name'                  => 'Bens-father-5',
            'mothers_name'                  => 'Bens-mother-5',
            'birth_date'                    => date('2014-03-15'),
            'arrival_date'                  => date('2014-03-15'),
            'address'                       => 'address-5',
            'telephone'                     => '123456789',
            'number_of_children'            => '12',
            'relatives_residence'           => 'relatives residence-5',

//            'other_language'                => '',
            'language_interpreter_needed'   => 0,
            'is_benefiter_working'          => 1,
//            'legal_status_details'          => 'legal details',
            'working_legally'               => 1,
            'country_abandon_reason'        => 'country abandon reason',
            'travel_route'                  => 'travel route',
            'travel_duration'               => '2 weeks',
            'detention_duration'            => '',

//            'has_educational_reference'     => 6,
//            'educational_reference_actions' => 'education',
//            'educational_reference_date'    => date('2014-03-15'),

            'origin_country'                => 'origin country',
            'nationality_country'           => 'nationality country',
            'gender_id'                     => 1,
            'marital_status_id'             => 1,
            'education_id'                  => 9,
            'work_title_id'                 => 1
        ));
    }
}
