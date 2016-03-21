<?php namespace App\Services;

class SearchService{

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
