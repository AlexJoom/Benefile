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

        // TESTING SEEDS FOR PRESENTATION

        \DB::table('work_title_list_lookup')->insert(
            array(
                array('work_title' => 'ΟΙΚΟΔΟΜΗ'),
                array('work_title' => 'ΑΓΡΟΤΙΚΕΣ ΔΟΥΛΕΙΕΣ'),
            )
        );

        Benefiter::create(array(
                'folder_number'                 => 'KK1',
                'name'                          => 'Ben-name-1',
                'lastname'                      => 'Ben-lastname-1',
                'fathers_name'                  => 'Bens-father-1',
                'mothers_name'                  => 'Bens-mother-1',
                'birth_date'                    => date('1974-03-15'),
                'arrival_date'                  => date('2015-04-05'),
                'address'                       => 'address-1',
                'telephone'                     => '123456789',
                'number_of_children'            => '2',
                'relatives_residence'           => 'relatives residence-1',

//                'other_language'                => '',
                'language_interpreter_needed'   => 0,
                'is_benefiter_working'          => 1,
//                'legal_status_details'          => 'legal details',
                'working_legally'               => 1,
                'country_abandon_reason_id'        => 2,
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
            'birth_date'                    => date('1985-11-24'),
            'arrival_date'                  => date('2016-03-15'),
            'address'                       => 'address-2',
            'telephone'                     => '123456789',
            'number_of_children'            => '12',
            'relatives_residence'           => 'relatives residence-2',

//            'other_language'                => '',
            'language_interpreter_needed'   => 0,
            'is_benefiter_working'          => 1,
//            'legal_status_details'          => 'legal details',
            'working_legally'               => 1,
            'country_abandon_reason_id'        => 2,
            'travel_route'                  => 'travel route',
            'travel_duration'               => '2 weeks',
            'detention_duration'            => '',

//            'has_educational_reference'     => 2,
//            'educational_reference_actions' => 'education',
//            'educational_reference_date'    => date('2014-03-15'),

            'origin_country'                => 'origin country',
            'nationality_country'           => 'nationality country',
            'gender_id'                     => 2,
            'marital_status_id'             => 2,
            'education_id'                  => 4,
            'work_title_id'                 => 1
        ));

        Benefiter::create(array(
            'folder_number'                 => 'KK3',
            'name'                          => 'Ben-name-1',
            'lastname'                      => 'Ben-lastname-1',
            'fathers_name'                  => 'Bens-father-1',
            'mothers_name'                  => 'Bens-mother-1',
            'birth_date'                    => date('2004-03-15'),
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
            'country_abandon_reason_id'        => 3,
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
            'work_title_id'                 => 2
        ));

        Benefiter::create(array(
            'folder_number'                 => 'KK4',
            'name'                          => 'Ben-name-3',
            'lastname'                      => 'Ben-lastname-3',
            'fathers_name'                  => 'Bens-father-3',
            'mothers_name'                  => 'Bens-mother-3',
            'birth_date'                    => date('1990-06-23'),
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
            'country_abandon_reason_id'        => 4,
            'travel_route'                  => 'travel route',
            'travel_duration'               => '2 weeks',
            'detention_duration'            => '',

//            'has_educational_reference'     => 4,
//            'educational_reference_actions' => 'education',
//            'educational_reference_date'    => date('2014-03-15'),

            'origin_country'                => 'origin country',
            'nationality_country'           => 'nationality country',
            'gender_id'                     => 1,
            'marital_status_id'             => 2,
            'education_id'                  => 2,
            'work_title_id'                 => 3
        ));

        Benefiter::create(array(
            'folder_number'                 => 'KK5',
            'name'                          => 'Ben-name-4',
            'lastname'                      => 'Ben-lastname-4',
            'fathers_name'                  => 'Bens-father-4',
            'mothers_name'                  => 'Bens-mother-4',
            'birth_date'                    => date('1994-11-07'),
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
            'country_abandon_reason_id'        => 5,
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
            'work_title_id'                 => 3,
            'created_at'                    => date('2015-01-25')
        ));

        Benefiter::create(array(
            'folder_number'                 => 'KK6',
            'name'                          => 'Ben-name-5',
            'lastname'                      => 'Ben-lastname-5',
            'fathers_name'                  => 'Bens-father-5',
            'mothers_name'                  => 'Bens-mother-5',
            'birth_date'                    => date('1992-07-10'),
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
            'country_abandon_reason_id'        => 3,
            'travel_route'                  => 'travel route',
            'travel_duration'               => '2 weeks',
            'detention_duration'            => '',

//            'has_educational_reference'     => 6,
//            'educational_reference_actions' => 'education',
//            'educational_reference_date'    => date('2014-03-15'),

            'origin_country'                => 'origin country',
            'nationality_country'           => 'nationality country',
            'gender_id'                     => 1,
            'marital_status_id'             => 4,
            'education_id'                  => 1,
            'work_title_id'                 => 1,
            'created_at'                    => date('2014-03-15')
        ));

        \DB::table('benefiters_legal_status')->insert(
            array(
                array(
                    'description' => 'description 1',
                    'exp_date' => date('2017-03-15'),
                    'benefiter_id' => 1,
                    'legal_lookup_id' => 1,
                ),
                array(
                    'description' => 'description 2',
                    'exp_date' => date('2017-04-17'),
                    'benefiter_id' => 3,
                    'legal_lookup_id' => 2,
                ),
                array(
                    'description' => 'description 3',
                    'exp_date' => date('2017-02-25'),
                    'benefiter_id' => 6,
                    'legal_lookup_id' => 1,
                ),
            )
        );

        \DB::table('medical_visits')->insert(
            array(
                array(
                    'benefiter_id' => 1,
                    'doctor_id' => 1,
                    'medical_location_id' => 1,
                    'medical_incident_id' => 1,
                    'medical_visit_date' => date('2015-07-02'),
                ),
                array(
                    'benefiter_id' => 1,
                    'doctor_id' => 1,
                    'medical_location_id' => 2,
                    'medical_incident_id' => 2,
                    'medical_visit_date' => date('2015-06-02'),
                ),
                array(
                    'benefiter_id' => 1,
                    'doctor_id' => 5,
                    'medical_location_id' => 1,
                    'medical_incident_id' => 2,
                    'medical_visit_date' => date('2014-12-20'),
                ),
                array(
                    'benefiter_id' => 2,
                    'doctor_id' => 1,
                    'medical_location_id' => 1,
                    'medical_incident_id' => 1,
                    'medical_visit_date' => date('2015-07-02'),
                ),
                array(
                    'benefiter_id' => 3,
                    'doctor_id' => 5,
                    'medical_location_id' => 1,
                    'medical_incident_id' => 1,
                    'medical_visit_date' => date('2015-07-02'),
                ),
                array(
                    'benefiter_id' => 6,
                    'doctor_id' => 5,
                    'medical_location_id' => 1,
                    'medical_incident_id' => 1,
                    'medical_visit_date' => date('2015-07-02'),
                ),
            )
        );

        \DB::table('medical_examination_results')->insert(
            array(
                array(
                    'description' => 'description-1',
                    'icd10_id' => 12,
                    'medical_visit_id' => 1,
                    'results_lookup_id' => 1,
                ),
                array(
                    'description' => 'description-2',
                    'icd10_id' => 212,
                    'medical_visit_id' => 1,
                    'results_lookup_id' => 5,
                ),
                array(
                    'description' => 'description-3',
                    'icd10_id' => 312,
                    'medical_visit_id' => 2,
                    'results_lookup_id' => 2,
                ),
                array(
                    'description' => 'description-4',
                    'icd10_id' => 15,
                    'medical_visit_id' => 4,
                    'results_lookup_id' => 1,
                ),
                array(
                    'description' => 'description-5',
                    'icd10_id' => 412,
                    'medical_visit_id' => 4,
                    'results_lookup_id' => 1,
                ),
                array(
                    'description' => 'description-6',
                    'icd10_id' => 212,
                    'medical_visit_id' => 4,
                    'results_lookup_id' => 1,
                ),
                array(
                    'description' => 'description-7',
                    'icd10_id' => 912,
                    'medical_visit_id' => 6,
                    'results_lookup_id' => 3,
                ),
                array(
                    'description' => 'description-8',
                    'icd10_id' => 1012,
                    'medical_visit_id' => 5,
                    'results_lookup_id' => 1,
                ),
            )
        );

        \DB::table('medical_examinations')->insert(
            array(
                array(
                    'height' => 0,
                    'weight' => 0,
                    'skull_perimeter' => 0,
                    'temperature' => 0,
                    'blood_pressure_diastolic' => 0,
                    'blood_pressure_systolic' => 0,
                    'examination_date' => date('2015-06-30'),
                    'description' => 'description',
                    'medical_visit_id' => 1,
                ),
                array(
                    'height' => 0,
                    'weight' => 0,
                    'skull_perimeter' => 0,
                    'temperature' => 0,
                    'blood_pressure_diastolic' => 0,
                    'blood_pressure_systolic' => 0,
                    'examination_date' => date('2015-06-30'),
                    'description' => 'description',
                    'medical_visit_id' => 2,
                ),
                array(
                    'height' => 0,
                    'weight' => 0,
                    'skull_perimeter' => 0,
                    'temperature' => 0,
                    'blood_pressure_diastolic' => 0,
                    'blood_pressure_systolic' => 0,
                    'examination_date' => date('2015-06-30'),
                    'description' => 'description',
                    'medical_visit_id' => 3,
                ),
                array(
                    'height' => 0,
                    'weight' => 0,
                    'skull_perimeter' => 0,
                    'temperature' => 0,
                    'blood_pressure_diastolic' => 0,
                    'blood_pressure_systolic' => 0,
                    'examination_date' => date('2015-06-30'),
                    'description' => 'description',
                    'medical_visit_id' => 4,
                ),
                array(
                    'height' => 0,
                    'weight' => 0,
                    'skull_perimeter' => 0,
                    'temperature' => 0,
                    'blood_pressure_diastolic' => 0,
                    'blood_pressure_systolic' => 0,
                    'examination_date' => date('2015-06-30'),
                    'description' => 'description',
                    'medical_visit_id' => 5,
                ),
                array(
                    'height' => 0,
                    'weight' => 0,
                    'skull_perimeter' => 0,
                    'temperature' => 0,
                    'blood_pressure_diastolic' => 0,
                    'blood_pressure_systolic' => 0,
                    'examination_date' => date('2015-06-30'),
                    'description' => 'description',
                    'medical_visit_id' => 6,
                ),
            )
        );

        \DB::table('social_folder')->insert(
            array(
                array(
                    'benefiter_id' => 1,
                ),
                array(
                    'benefiter_id' => 2,
                ),
                array(
                    'benefiter_id' => 3,
                ),
                array(
                    'benefiter_id' => 4,
                ),
                array(
                    'benefiter_id' => 5,
                ),
                array(
                    'benefiter_id' => 6,
                ),
            )
        );

        \DB::table('psychosocial_sessions')->insert(
            array(
                array(
                    'session_date' => date('2016-02-03'),
                    'session_comments' => 'comments-1',
                    'social_folder_id' => 1,
                    'psychosocial_theme_id' => 1,
                    'psychologist_id' => 4,
                ),
                array(
                    'session_date' => date('2015-12-13'),
                    'session_comments' => 'comments-2',
                    'social_folder_id' => 1,
                    'psychosocial_theme_id' => 2,
                    'psychologist_id' => 8,
                ),
                array(
                    'session_date' => date('2016-01-23'),
                    'session_comments' => 'comments-3',
                    'social_folder_id' => 2,
                    'psychosocial_theme_id' => 1,
                    'psychologist_id' => 4,
                ),
                array(
                    'session_date' => date('2016-02-03'),
                    'session_comments' => 'comments-4',
                    'social_folder_id' => 1,
                    'psychosocial_theme_id' => 4,
                    'psychologist_id' => 12,
                ),
                array(
                    'session_date' => date('2016-02-03'),
                    'session_comments' => 'comments-5',
                    'social_folder_id' => 5,
                    'psychosocial_theme_id' => 5,
                    'psychologist_id' => 4,
                ),
                array(
                    'session_date' => date('2014-02-03'),
                    'session_comments' => 'comments-6',
                    'social_folder_id' => 5,
                    'psychosocial_theme_id' => 1,
                    'psychologist_id' => 4,
                ),
                array(
                    'session_date' => date('2013-02-03'),
                    'session_comments' => 'comments-7',
                    'social_folder_id' => 6,
                    'psychosocial_theme_id' => 1,
                    'psychologist_id' => 4,
                ),
                array(
                    'session_date' => date('2016-02-03'),
                    'session_comments' => 'comments-8',
                    'social_folder_id' => 1,
                    'psychosocial_theme_id' => 1,
                    'psychologist_id' => 4,
                ),
                array(
                    'session_date' => date('2016-02-03'),
                    'session_comments' => 'comments-9',
                    'social_folder_id' => 4,
                    'psychosocial_theme_id' => 1,
                    'psychologist_id' => 4,
                ),
            )
        );
    }
}
