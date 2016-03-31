<?php

namespace App\Http\Controllers\Medical_Folder;


use App\Services\Medical_folder\BenefiterMedicalFolderDBdependentService;
use App\Services\DatesHelper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MedicalFolderExtraFunctionsController extends Controller{

    private $medicalVisitDBDependencies;
    private $datesHelper;

    // constructor
    public function __construct(){
        // only for logged in users
        $this->middleware('activated');
        $this->medicalVisitDBDependencies = new BenefiterMedicalFolderDBdependentService();
        $this->datesHelper = new DatesHelper();
    }

    //------ MEDICATION LIST FETCH "LIKE" OBJECTS ---------------------------------//
    public function getMedicationList(Request $request){
        $full_medication_name = $this->medicalVisitDBDependencies->get_full_medication_name($request['q']);
        return $full_medication_name;
    }

    //------ ICD10 SELECT LIST FETCH "LIKE" OBJECTS -------------------------------//
    public function getICD10List(Request $request){
        $full_icd10_description = $this->medicalVisitDBDependencies->get_full_icd10_description($request['q']);
        return $full_icd10_description;
    }


    //----- GET MEDICAL VISIT MODAL DATA FOR BENEFITER FOR EACH VISIT -------------//
    public function getMedicalVisitModal(Request $request, $id){
        // ------ MODAL: MEDICAL HISTORY DATA FOR EACH MEDICAL VISIT ------ //
        // initialize
        $med_visit_doctor = '';
        $med_visit_date = '';
        $med_visit_location = '';
        $med_visit_incident_type = '';
        $med_visit_chronic_conditions = '';
        $med_visit_height = '';
        $med_visit_weight = '';
        $med_visit_temperature = '';
        $med_visit_blood_pressure_systolic = '';
        $med_visit_blood_pressure_diastolic = '';
        $med_visit_skull_perimeter = '';
        $med_visit_exam_results = '';
        $med_visit_lab_results = '';
        $med_visit_medication = '';
        $med_visit_referrals = '';
        $med_visit_uploads = '';
        // TODO CREATE A SERVICE THAT RETURNS A JSON WITH ALL INFO FOR EVERY VISIT
        $current_benefiter_medical_visit_id = $request['current_medical_visit'];
        $benefiter_medical_visits_list = $this->medicalVisitDBDependencies->get_all_medical_visits_for_benefiter($id);
        $benefiter_folder_number = $this->medicalVisitDBDependencies->find_benefiter_folder_number($id);
        $benefiter = $this->medicalVisitDBDependencies->find_benefiter_by_id($id);
        $ExamResultsLookup = $this->medicalVisitDBDependencies->get_medical_examination_results_from_lookup();
        // for every medical visit of the benefiter fetch the corresponding medical data from DB
        foreach($benefiter_medical_visits_list as $med_visit) {
            if ($med_visit['id'] == $current_benefiter_medical_visit_id) {
                //Doctor Name
                $med_visit_doctor = $med_visit['doctor']['name'] . ' ' . $med_visit['doctor']['lastname'];
                // Examination date
                if ($med_visit['medical_visit_date'] == null) {
                    $med_visit_date = $this->datesHelper->getFinelyFormattedStringDateFromDBDate($med_visit['created_at']);
                } else {
                    $med_visit_date = $this->datesHelper->getFinelyFormattedStringDateFromDBDate($med_visit['medical_visit_date']);
                }
                // Visit location
                $med_visit_location = $med_visit['medicalLocation']['description'];
                // Visit incident type
                $med_visit_incident_type = $med_visit['medicalIncidentType']['description'];
                // Chronic Conditions
                $med_visit_chronic_conditions = $this->medicalVisitDBDependencies->findMedicalChronicConditionsForBenefiter($id, $med_visit['id']);
                // physical examinations
                $med_visit_examination = $this->medicalVisitDBDependencies->findMedicalVisitExamination($med_visit['id']);
                // height
                $med_visit_height = $med_visit_examination['height'];
                // weight
                $med_visit_weight = $med_visit_examination['weight'];
                // temperature
                $med_visit_temperature = $med_visit_examination['temperature'];
                // blood pressure
                $med_visit_blood_pressure_systolic = $med_visit_examination['blood_pressure_systolic'];
                $med_visit_blood_pressure_diastolic = $med_visit_examination['blood_pressure_diastolic'];
                // skull_perimeter
                $med_visit_skull_perimeter = $med_visit_examination['skull_perimeter'];
                // Examination results
                $med_visit_exam_results = $this->medicalVisitDBDependencies->findMedicalVisitExaminationResults($med_visit['id']);
                // Lab results
                $med_visit_lab_results = $this->medicalVisitDBDependencies->findMedicalVisitLabResults($med_visit['id']);
                // Medication
                $med_visit_medication = $this->medicalVisitDBDependencies->findMedicalVisitMedication($med_visit['id']);
                // Referrals
                $med_visit_referrals = $this->medicalVisitDBDependencies->findMedicalVisitReferrals($med_visit['id']);
                // Uploads
                $med_visit_uploads = $this->medicalVisitDBDependencies->findMedicalVisitUploads($med_visit['id']);
            }
        }
        // ------ END MODAL: MEDICAL HISTORY DATA FOR EACH MEDICAL VISIT ------ //
        return  view('partials.modals.medical_visit_info')
                                        ->with('benefiter_medical_visits_list', $benefiter_medical_visits_list)
                                        ->with('med_visit_doctor', $med_visit_doctor)
                                        ->with('med_visit_location', $med_visit_location)
                                        ->with('med_visit_incident_type', $med_visit_incident_type)
                                        ->with('med_visit_chronic_conditions', $med_visit_chronic_conditions)
                                        ->with('med_visit_height', $med_visit_height)
                                        ->with('med_visit_weight', $med_visit_weight)
                                        ->with('med_visit_temperature', $med_visit_temperature)
                                        ->with('med_visit_blood_pressure_systolic', $med_visit_blood_pressure_systolic)
                                        ->with('med_visit_blood_pressure_diastolic', $med_visit_blood_pressure_diastolic)
                                        ->with('med_visit_skull_perimeter', $med_visit_skull_perimeter)
                                        ->with('med_visit_exam_results', $med_visit_exam_results)
                                        ->with('med_visit_lab_results', $med_visit_lab_results)
                                        ->with('med_visit_medication', $med_visit_medication)
                                        ->with('med_visit_referrals', $med_visit_referrals)
                                        ->with('med_visit_uploads', $med_visit_uploads)
                                        ->with('benefiter_folder_number', $benefiter_folder_number)
                                        ->with('benefiter', $benefiter)
                                        ->with('ExamResultsLookup', $ExamResultsLookup)
                                        ->with('med_visit_date', $med_visit_date);
    }
}
