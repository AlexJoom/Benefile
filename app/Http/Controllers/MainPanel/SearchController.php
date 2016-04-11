<?php

namespace App\Http\Controllers\MainPanel;

//use App\Services\BasicInfoService;
use App\Services\Medical_folder\BenefiterMedicalFolderService;
use App\Services\Medical_folder\BenefiterMedicalFolderDBdependentService;
use Illuminate\Http\Request;
use App\Services\SearchService;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller{
    private $medical_folder_db_dependent_services;

    public function __construct(){
        // only for logged in users
        $this->middleware('activated');
//        $this->middleware('auth');
        // initialize db dependent services for medical folder
        $this->medical_folder_db_dependent_services = new BenefiterMedicalFolderDBdependentService();
    }

    // returns the search view
    public function getSearch(){
        $medicalService = new BenefiterMedicalFolderService();
        $searchService = new SearchService();
        // all the marital statuses
        $allMaritalStatuses = $searchService->getAllMaritalStatuses();
        // all the legal statuses
        $allLegalStatuses = $searchService->getAllLegalStatuses();
        // all the education titles
        $allEducationTitles = $searchService->getAllEducationTitles();
        // all the work titles
        $allWorkTitles = $searchService->getAllWorkTitles();
        // all the medical incident types
        $allMedicalIncidentTypes = $searchService->getAllMedicalIncidentTypes();
        // all the medical examination results
        $allMedicalExaminationResults = $searchService->getAllMedicalExaminationResults();
        // all the medical locations
        $medicalLocations = $this->medical_folder_db_dependent_services->get_all_medical_locations_lookup();
        return view('search.search')
            ->with('medical_locations', $medicalLocations)
            ->with('marital_statuses', $allMaritalStatuses)
            ->with('legal_statuses', $allLegalStatuses)
            ->with('education_titles', $allEducationTitles)
            ->with('work_titles', $allWorkTitles)
            ->with('medical_incident_types', $allMedicalIncidentTypes)
            ->with('medical_examination_results', $allMedicalExaminationResults);
    }

    // gets the search parameters and returns the results to view
    public function getResults(Request $request){
        $searchService = new SearchService();
        $results = $searchService->searchBenefiters($request->all());
        return $results;
    }
}
