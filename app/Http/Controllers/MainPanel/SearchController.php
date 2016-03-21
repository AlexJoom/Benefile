<?php

namespace App\Http\Controllers\MainPanel;

use App\Services\BasicInfoService;
use App\Services\BenefiterMedicalFolderService;
use Illuminate\Http\Request;
use App\Services\SearchService;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
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
        $medicalLocations = $medicalService->getAllMedicalLocations();
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
        $basicInfoService = new BasicInfoService();
        $results = $basicInfoService->searchBenefitersTable($request->folder_number,
                $request->lastname,
                $request->name,
                $request->fathers_name,
                $request->gender_id,
                $request->telephone,
                $request->birth_date,
                $request->origin_country,
                $request->medical_location_id
            );
        return $results;
    }
}
