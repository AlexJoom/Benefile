<?php
/**
 * Created by PhpStorm.
 * User: cdimitzas
 * Date: 29/3/2016
 * Time: 12:59 μμ
 */

namespace App\Services\Medical_folder;

use App\Models\Benefiters_Tables_Models\medical_visits;
use App\Models\Benefiters_Tables_Models\medical_chronic_conditions;
use App\Models\Benefiters_Tables_Models\medical_examination_results_lookup;
use App\Models\Benefiters_Tables_Models\medical_examination_results;
use App\Models\Benefiters_Tables_Models\medical_examinations;
use App\Models\Benefiters_Tables_Models\medical_laboratory_results;
use App\Models\Benefiters_Tables_Models\medical_medication;
use App\Models\Benefiters_Tables_Models\medical_referrals;
use App\Models\Benefiters_Tables_Models\medical_uploads;
use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\medical_location_lookup;
use App\Models\Benefiters_Tables_Models\medical_incident_type_lookup;
use App\Models\Benefiters_Tables_Models\medical_medication_lookup;
use App\Models\Benefiters_Tables_Models\ICD10;
use Illuminate\Support\Facades\Auth;

class BenefiterMedicalFolderDBdependentService{

    // ----------------------------MEDICAL VISIT TABLE -----------------------------------//

    // find medical visit by id (frond end gives the clicked value and we search for the corresponding db id)
    public function find_medical_visit_by_id($selected_medical_visit_id){
        $medical_visit_by_id = medical_visits::find($selected_medical_visit_id);
        return $medical_visit_by_id;
    }
    // get all medical visits for a benefiter
    public function get_all_medical_visits_for_benefiter($id){
        $benefiter_medical_history_list = medical_visits::where('benefiter_id', $id)->with('doctor', 'medicalLocation', 'medicalIncidentType')->get();
        return $benefiter_medical_history_list;
    }
    // count benefiter's medical visits
    public function count_medical_visits_for_a_benefiter($id){
        $medical_visits_number = medical_visits::where('benefiter_id', $id)->count();
        return $medical_visits_number;
    }



    // ---------------------- MEDICAL CHRONIC CONDITIONS TABLE ---------------------------//

    // find medical chronic conditions by medical visit id
    public function find_medical_chronic_conditions_by_medical_visit_id($selected_medical_visit_id){
        $saved_medical_chronic_conditions = medical_chronic_conditions::where("medical_visit_id", $selected_medical_visit_id)->get();
        return $saved_medical_chronic_conditions;
    }
    // find medical chronic condition by id
    public function find_medical_chronic_condition_by_id($id){
        $medical_chronic_condition = medical_chronic_conditions::find($id);
        return $medical_chronic_condition;
    }
    // chronic conditions for each benefiter
    public function findMedicalChronicConditionsForBenefiter($benefiter_id, $medical_visit_id){
        return medical_chronic_conditions::where('benefiters_id', $benefiter_id)->where('medical_visit_id', $medical_visit_id)->with('chronic_conditions_lookup')->get();;
    }



    // --------------------- MEDICAL EXAMINATION RESULTS TABLE --------------------------- //

    // find examinations with same clinical result
    public function find_examinations_with_same_clinical_result($selected_medical_visit_id, $clinical_result_id){
        $saved_examinations_with_same_clinical_result = medical_examination_results::where("medical_visit_id", $selected_medical_visit_id)
            ->where("results_lookup_id", $this->find_medical_examination_results_lookup_id($clinical_result_id))->get();
        return $saved_examinations_with_same_clinical_result;
    }
    // find medical examination result by id
    public function find_medical_examination_result_by_id($id){
        $medical_examination_result = medical_examination_results::find($id);
        return $medical_examination_result;
    }
    // Examination results
    public function findMedicalVisitExaminationResults($med_visit_id){
        $med_visit_exam_results = medical_examination_results::where('medical_visit_id', $med_visit_id)->with('icd10')->get();
        return $med_visit_exam_results;
    }
    // find medical examination results by id
    public function find_medical_examination_results_lookup_id($id){
        $medical_examination_results_lookup_id = medical_examination_results_lookup::where('id', '=', $id)->first()['attributes']['id'];
        return $medical_examination_results_lookup_id;
    }
    // get all medical examinaiton results from lookup
    public function get_medical_examination_results_from_lookup(){
        $ExamResultsLookup = medical_examination_results_lookup::get()->all();
        return $ExamResultsLookup;
    }



    // --------------------- MEDICAL EXAMINATION TABLE ---------------------------------- //

    // find medical examination results with same medical visit id
    public function find_medical_examination_results_with_same_medical_visit_id($selected_medical_visit_id){
        $medical_examination = medical_examinations::where("medical_visit_id", $selected_medical_visit_id)->first();
        return $medical_examination;
    }
    // physical examinations
    public function findMedicalVisitExamination($med_visit_id){
        $med_visit_examination = medical_examinations::where('medical_visit_id', $med_visit_id)->first();
        return $med_visit_examination;
    }



    // --------------------- MEDICAL LABORATORY RESULTS TABLE --------------------------- //

    // find all laboratory results with same medical visit id
    public function find_medical_lab_results_with_same_medical_visit_id($selected_medical_visit_id){
        $saved_lab_results = medical_laboratory_results::where("medical_visit_id", $selected_medical_visit_id)->get();
        return $saved_lab_results;
    }
    // find laboratory result by id
    public function find_laboratory_result_by_id($id){
        $lab_result = medical_laboratory_results::find($id);
        return $lab_result;
    }
    // Lab results
    public function findMedicalVisitLabResults($med_visit_id){
        $med_visit_lab_results = medical_laboratory_results::where('medical_visit_id', $med_visit_id)->get();
        return $med_visit_lab_results;
    }



    // --------------------- MEDICAL MEDICATION TABLE ----------------------------------- //

    // find all medications with the same medical visit id
    public function find_medications_with_same_medical_visit_id($selected_medical_visit_id){
        $saved_medication = medical_medication::where("medical_visit_id", $selected_medical_visit_id)->get();
        return $saved_medication;
    }
    // find medication by id
    public function find_medication_by_id($id){
        $med_medication = medical_medication::find($id);
        return $med_medication;
    }
    // Medication
    public function findMedicalVisitMedication($med_visit_id){
        $med_visit_medication = medical_medication::where('medical_visit_id', $med_visit_id)->with('medical_medication_lookup')->get();
        return $med_visit_medication;
    }
    // find medication name by id
    public function getMedicationLookupBy_id($id){
        $medicine_name = medical_medication_lookup::where('id', '=', $id)->first()->description;
        return $medicine_name;
    }
    // find medical medicinal name from lookup using partial name
    public function get_full_medication_name($partial_name){
        $full_medication_name = medical_medication_lookup::where('description','LIKE', '%'.$partial_name.'%' )->get();
        return $full_medication_name;
    }



    // --------------------- MEDICAL REFERRALS TABLE ----------------------------------- //

    // find all medical referrals with the same medical visit id
    public function find_medical_referrals_with_same_medical_visit_id($selected_medical_visit_id){
        $saved_medical_referrals = medical_referrals::where("medical_visit_id", $selected_medical_visit_id)->get();
        return $saved_medical_referrals;
    }
    // find medical referral by id
    public function find_medical_referral_by_id($id){
        $med_referral = medical_referrals::find($id);
        return $med_referral;
    }
    // Referrals
    public function findMedicalVisitReferrals($med_visit_id){
        $med_visit_referrals = medical_referrals::where('medical_visit_id', $med_visit_id)->get();
        return $med_visit_referrals;
    }


    // --------------------- MEDICAL UPLOADS TABLE -------------------------------------- //

    // find all medical uploaded files with same medical visit id
    public function find_medical_uploads_with_same_medical_visit_id($selected_medical_visit_id){
        $saved_files = medical_uploads::where("medical_visit_id", $selected_medical_visit_id)->get();
        return $saved_files;
    }
    // find medical upload by id
    public function find_medical_upload_by_id($id){
        $medical_upload = medical_uploads::find($id);
        return $medical_upload;
    }
    // Uploads
    public function findMedicalVisitUploads($med_visit_id){
        $med_visit_uploads = medical_uploads::where('medical_visit_id', $med_visit_id)->get();
        return $med_visit_uploads;
    }



    // --------------------- BENEFITERS TABLE ------------------------------------------- //

    // find benefiter folder number
    public function find_benefiter_folder_number($id){
        $benefiter_folder_number = Benefiter::where('id', '=', $id)->first()->folder_number;
        return $benefiter_folder_number;
    }
    // find a benefiter from its id
    public function find_benefiter_by_id($id){
        return Benefiter::where('id', '=', $id)->with('gender')->first();
    }



    // --------------------- MEDICAL LOCATION LOOKUP TABLE ------------------------------ //

    // return all the medical locations
    public function get_all_medical_locations_lookup(){
        $medical_locations = medical_location_lookup::get()->all();
        return $medical_locations;
    }



    // --------------------- MEDICAL INCIDENT TYPE LOOKUP TABLE ------------------------- //

    // Incident type
    public function medical_incident_type_lookup(){
        $medical_incident_type = medical_incident_type_lookup::get();
        return $medical_incident_type;
    }



    // --------------------- ICD10 TABLE ------------------------------------------------ //

    // find name of ICD10 list by id
    public function getICD10By_id($id){
        $description = ICD10::where('id', '=', $id)->first()->description;
        $code = ICD10::where('id', '=', $id)->first()->code;
        $result = $code .': '. $description;
        return $result;
    }
    // find ICD10 from lookup using partial name
    public function get_full_icd10_description($partial_name){
        $full_icd10_description = ICD10::where('description','LIKE', '%'.$partial_name.'%' )->get();
        return $full_icd10_description;
    }



    // --------------------- USERS TABLE ------------------------------------------------ //

    // get logged in user id
    public function get_logged_in_user_id(){
        $user_id = Auth::user()->id;
        return $user_id;
    }
} 