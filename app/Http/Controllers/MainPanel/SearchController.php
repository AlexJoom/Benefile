<?php

namespace App\Http\Controllers\MainPanel;

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
        return view('search.search_results');
    }
}
