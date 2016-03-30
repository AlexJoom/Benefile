<?php

namespace App\Http\Controllers\Medical_Folder;

use Illuminate\Http\Request;

// services used
use App\Services\BasicInfoService;
use App\Services\BenefitersService;
use App\Services\Validation_services\Medical_folder\BenefiterMedicalFolderValidationService;
use App\Services\Medical_folder\BenefiterMedicalFolderService;
use App\Services\Utilities\GeneralUseService;
use App\Services\Medical_folder\BenefiterMedicalFolderDBdependentService;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EditMedicalVisitController extends Controller{

    // services
    private $basicInfoService;

    public function __construct(){
        // only for logged in users
        $this->middleware('activated');
        // initialize benefiters list service
        $this->benefiterList = new BenefitersService();
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize validator for medical visit edit
        $this->edit_medical_visit_validator = new BenefiterMedicalFolderValidationService();
        // initialize medical visit service
        $this->medicalVisit = new BenefiterMedicalFolderService();
        // initialize general use service
        $this->generalUseService = new GeneralUseService();
        // initialize services for medical visit with DB dependencies
        $this->medicalVisitDBDependencies = new BenefiterMedicalFolderDBdependentService();

        $this->datesHelper = new \app\Services\DatesHelper();
    }

    //------------ GET: EDIT MEDICAL VISIT ----------------------------------------//
    public function getMedicalVisitForEditing(Request $request, $id){
        $selected_medical_visit_id = $request['medical_visit_id'];
        $benefiter = $this->medicalVisitDBDependencies->find_benefiter_by_id($id);
        $benefiter_medical_visits_list = $this->medicalVisitDBDependencies->get_all_medical_visits_for_benefiter($id);
//        $doctor_id = $this->medicalVisit->findDoctorId();
        $medical_locations = $this->medicalVisitDBDependencies->get_all_medical_locations_lookup();
        $medical_incident_type = $this->medicalVisitDBDependencies->medical_incident_type_lookup();
        $medical_locations_array = $this->generalUseService->reindex_array($medical_locations);
        $medical_incident_type_array = $this->generalUseService->reindex_array($medical_incident_type);
        $ExamResultsLookup = $this->medicalVisitDBDependencies->get_medical_examination_results_from_lookup();

        // initialize variables
        $med_visit_doctor = '';
        $med_visit_date = '';
        $med_visit_location_id = '';
        $med_visit_incident_type_id = '';
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

        // for every medical visit of the benefiter fetch the corresponding medical data from DB
        foreach($benefiter_medical_visits_list as $med_visit) {
            if ($med_visit['id'] == $selected_medical_visit_id) {
                $doctor_id = $med_visit['doctor']['id'];
                //Doctor Name
                $med_visit_doctor = $med_visit['doctor']['name'] . ' ' . $med_visit['doctor']['lastname'];
                // Examination date
                if ($med_visit['medical_visit_date'] == null) {
                    $med_visit_date = $this->datesHelper->getFinelyFormattedStringDateFromDBDate($med_visit['created_at']);
                } else {
                    $med_visit_date = $this->datesHelper->getFinelyFormattedStringDateFromDBDate($med_visit['medical_visit_date']);
                }
                // Visit location
                $med_visit_location_id = $med_visit['medical_location_id'];
                // Visit incident type
                $med_visit_incident_type_id = $med_visit['medical_incident_id'];
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
        return view('partials.forms.medical-visit.medical_visit_edit')
            ->with('selected_medical_visit_id',$selected_medical_visit_id)
            ->with('benefiter',$benefiter)
            ->with('doctor_id',$doctor_id)
            ->with('med_visit_date',$med_visit_date)
            ->with('med_visit_location_id',$med_visit_location_id)
            ->with('med_visit_incident_type_id',$med_visit_incident_type_id)
            ->with('med_visit_chronic_conditions',$med_visit_chronic_conditions)
            ->with('med_visit_height',$med_visit_height)
            ->with('med_visit_weight',$med_visit_weight)
            ->with('med_visit_temperature',$med_visit_temperature)
            ->with('med_visit_blood_pressure_systolic',$med_visit_blood_pressure_systolic)
            ->with('med_visit_blood_pressure_diastolic',$med_visit_blood_pressure_diastolic)
            ->with('med_visit_skull_perimeter',$med_visit_skull_perimeter)
            ->with('med_visit_exam_results',$med_visit_exam_results)
            ->with('med_visit_lab_results',$med_visit_lab_results)
            ->with('med_visit_medication',$med_visit_medication)
            ->with('med_visit_referrals',$med_visit_referrals)
            ->with('med_visit_uploads',$med_visit_uploads)
            ->with('medical_locations_array',$medical_locations_array)
            ->with('medical_incident_type_array',$medical_incident_type_array)
            ->with('ExamResultsLookup',$ExamResultsLookup)
            ->with('med_visit_doctor',$med_visit_doctor)
            ->with('$benefiter_medical_visits_list', $benefiter_medical_visits_list);
    }


    //------------ POST: EDIT MEDICAL VISIT ---------------------------------------//
    public function postMedicalVisitFromEditing(Request $request){
        $selected_medical_visit_id = $request['selected_medical_visit_id'];
        $benefiter_id = $request['benefiter_id'];
//        dd($request->all());

        // Post Validation
        $validator = $this->edit_medical_visit_validator->medicalValidationService($request->all());
        if($validator->fails()){
            $visit_submited_succesfully = 2; // 0:initial value, 1:Success, 2:Unsuccess
            return redirect('benefiter/'.$benefiter_id.'/editMedicalVisit?medical_visit_id='.$selected_medical_visit_id)
                ->with('visit_submited_succesfully', $visit_submited_succesfully)
                ->withErrors($validator->errors()->all());
        } else {
            $this->medicalVisit->update_medical_visit_tables($request->all(), $selected_medical_visit_id);
            $visit_submited_succesfully = 3; // 0:initial value, 1:Success, 2:Unsuccess, 3: Success update
            return redirect('benefiter/'.$benefiter_id.'/medical-folder')
                ->with('selected_medical_visit_id', $selected_medical_visit_id)
                ->with('visit_submited_succesfully', $visit_submited_succesfully);
        }

    }
}
