<?php
use Illuminate\Database\Seeder;

class MedicalExaminaitonsSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        \DB::table('medical_examination_results_lookup')->insert(
            array(
                array('description' => "RESPIRATORY SYSTEM"),
                array('description' => "DIGESTIVE SYSTEM"),
                array('description' => "SKIN & CUTANEOUS TISSUE"),
                array('description' => "CARDIOVASCULAR SYSTEM"),
                array('description' => "URINARY/REPRODUCTIVE SYSTEM"),
                array('description' => "MUSCULOSKELETAL SYSTEM"),
                array('description' => "IMMUNIZATION (vaccine & date)"),
                array('description' => "NERVOUS SYSTEM & SENSE ORGANS"),
                array('description' => "OTHER"),
            )
        );
    }
}
