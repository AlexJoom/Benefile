<?php

namespace App\Http\Controllers\MainPanel;

use App\Services\BasicInfoService;
use App\Services\BenefiterMedicalFolderService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    // returns the search view
    public function getSearch(){
        $medicalService = new BenefiterMedicalFolderService();
        $medicalLocations = $medicalService->getAllMedicalLocations();
        return view('search.search')->with('medical_locations', $medicalLocations);
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
        return view('search.search_results')->with('results', $results);
    }
}
