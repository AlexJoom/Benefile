<?php namespace App\Services;

use App\Services\ReportsService;

class DownloadFileService{

    private $reportsService;

    public function __construct(){
        // initialize reports service
        $this->reportsService = new ReportsService();
    }

    // make csv file
    public function makeCSVFileUsingBenefitersIds($idsString){
        $benefitersIds = $this->getBenefitersIdsArrayFromString($idsString);
        $allGenders = $this->getAllGenders();
        $allMaritalStatuses = $this->reportsService->getAllMaritalStatuses();
        $allEducationTitles = $this->reportsService->getAllEducationTitles();
        $allWorkTitles = $this->reportsService->getAllWorkTitles();
        foreach($benefitersIds as $benefiterId){
            // make benefiter_id specific DB queries
        }
    }

    // returns an array of ids from ids string
    private function getBenefitersIdsArrayFromString($idsString){
        return explode(',', $idsString);
    }

    // returns all the genders stored in the DB
    private function getAllGenders(){
        return \DB::table('genders_lookup')->get()->toArray();
    }
}
