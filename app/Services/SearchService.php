<?php namespace App\Services;

use Illuminate\Support\Facades\Log;

class SearchService{

    // perform DB search with the request parameters
    public function searchBenefiters($request){
        $datesHelper = new DatesHelper();
        $queryString = "select b.*, floor(datediff(current_date, str_to_date(b.birth_date, '%Y-%m-%d'))/365) as age_in_years, count(mv.id) as incidents_counter, date(b.created_at) as created_at_date from benefiters as b left join benefiters_legal_status as bls on b.id = bls.benefiter_id left join medical_visits as mv on b.id = mv.benefiter_id left join medical_examination_results as mer on mv.id = mer.medical_visit_id left join medical_medication as mm on mv.id = mm.medical_visit_id";
        $queryString2 = " group by b.id";
        $firstWhereParameter = true;
        $firstWhereParameterExternalSelect = true;
        if ($request['folder_number'] != ""){
            $queryString = $queryString . " where " . "b.folder_number='" . $request['folder_number'] . "'";
            $firstWhereParameter = false;
        }
        if ($request['lastname'] != ""){
            if (!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . "b.lastname like '%" . $request['lastname'] . "%'";
            $firstWhereParameter = false;
        }
        if ($request['fname'] != ""){
            if (!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . "b.name like '%" . $request['fname'] . "%'";
            $firstWhereParameter = false;
        }
        if ($request['fathers_name'] != ""){
            if (!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . "b.fathers_name like '%" . $request['fathers_name'] . "%'";
            $firstWhereParameter = false;
        }
        if ($request['telephone'] != ""){
            if (!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . "b.telephone='" . $request['telephone'] . "'";
            $firstWhereParameter = false;
        }
        if ($request['birth_date'] != ""){
            if (!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . "b.birth_date='" . $this->datesHelper->makeDBSearchFriendlyDate($this->datesHelper->makeDBFriendlyDate($request['birth_date'])) . "'";
            $firstWhereParameter = false;
        }
        if ($request['origin_country'] != ""){
            if (!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . "b.origin_country='" . $request['origin_country'] . "'";
            $firstWhereParameter = false;
        }
        if ($request['medical_location_id'] != "0"){
            if (!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . "b.medical_location_id=" . $request['medical_location_id'];
            $firstWhereParameter = false;
        }
        if($request['marital_status_id'] != 0) {
            if (!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'b.marital_status_id=' . $request['marital_status_id'];
            $firstWhereParameter = false;
        }
        if($request['legal_status_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'bls.legal_lookup_id=' . $request['legal_status_id'];
            $firstWhereParameter = false;
        }
        if($request['education_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'b.education_id=' . $request['education_id'];
            $firstWhereParameter = false;
        }
        if(!empty($request['gender_id'])){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'b.gender_id=' . $request['gender_id'];
            $firstWhereParameter = false;
        }
        if($request['work_title_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'b.work_title_id=' . $request['work_title_id'];
            $firstWhereParameter = false;
        }
        if($request['drug'] != ""){
            $drugId = $this->getMedicationIdFromName($request['drug']);
            if($drugId != null) {
                if (!$firstWhereParameter) {
                    $queryString = $queryString . " and ";
                } else {
                    $queryString = $queryString . " where ";
                }
                $queryString = $queryString . 'mm.medication_lookup_id=' . $drugId;
                $firstWhereParameter = false;
            }
        }
        if($request['incident_type_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'mv.medical_incident_id=' . $request['incident_type_id'];
            $firstWhereParameter = false;
        }
        if($request['doctor_name'] != ""){
            $doctorId = $this->getDoctorIdFromName($request['doctor_name']);
            if($doctorId != null) {
                if (!$firstWhereParameter) {
                    $queryString = $queryString . " and ";
                } else {
                    $queryString = $queryString . " where ";
                }
                $queryString = $queryString . 'mv.doctor_id=' . $doctorId;
                $firstWhereParameter = false;
            }
        }
        if($request['examination_results_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'mer.results_lookup_id=' . $request['examination_results_id'];
            $firstWhereParameter = false;
        }
        if($request['incident_from'] != "" and $request['incident_to'] != ""){
            // if difference in days between the two dates is negative, the incident_to date is earlier
            if($datesHelper->getDifferenceInDays($request['incident_from'], $request['incident_to']) < 0){
                $tmp = $request['incident_from'];
                $request['incident_from'] = $request['incident_to'];
                $request['incident_to'] = $tmp;
            }
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'mv.medical_visit_date between \'' . $datesHelper->makeDBSearchFriendlyDate($datesHelper->makeDBFriendlyDate($request['incident_from'])) . '\' and \'' . $datesHelper->makeDBSearchFriendlyDate($datesHelper->makeDBFriendlyDate($request['incident_to'])) . '\'';
            $firstWhereParameter = false;
        }
        $queryString = "select * from (" . $queryString . $queryString2 . ") as median_table";
        if($request['age'] != "" and is_numeric($request['age'])) {
            $queryString = $queryString . " where ";
            $queryString = $queryString . 'age_in_years=' . $request['age'];
            $firstWhereParameterExternalSelect = false;
        }
        if($request['incidents_number'] != ""){
            if(!$firstWhereParameterExternalSelect){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'incidents_counter=' . $request['incidents_number'];
            $firstWhereParameter = false;
        }
        if($request['insertion_date'] != ""){
            if(!$firstWhereParameterExternalSelect){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'created_at_date=\'' . $datesHelper->makeDBSearchFriendlyDate($datesHelper->makeDBFriendlyDate($request['insertion_date'])). '\'';
            $firstWhereParameterExternalSelect = false;
        }
        if(!$firstWhereParameter or !$firstWhereParameterExternalSelect) {
            Log::info("The search benefiter DB query is: " . $queryString);
            return \DB::select(\DB::raw($queryString));
        } else {
            Log::info("No parameters passed from benefiter search from!");
            return null;
        }
    }

    // returns all the marital statuses stored in DB
    public function getAllMaritalStatuses(){
        return \DB::table('marital_status_lookup')->get();
    }

    // returns all the legal statuses stored in DB
    public function getAllLegalStatuses(){
        return \DB::table('legal_status_lookup')->get();
    }

    // returns all the education titles stored in DB
    public function getAllEducationTitles(){
        return \DB::table('education_lookup')->get();
    }

    // returns all the work titles stored in DB
    public function getAllWorkTitles(){
        return \DB::table('work_title_list_lookup')->get();
    }

    // returns all the medical incident types stored in DB
    public function getAllMedicalIncidentTypes(){
        return \DB::table('medical_incident_type_lookup')->get();
    }

    // returns all the medical examination results stored in DB
    public function getAllMedicalExaminationResults(){
        return \DB::table('medical_examination_results_lookup')->get();
    }

}
