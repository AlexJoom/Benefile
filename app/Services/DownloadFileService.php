<?php namespace App\Services;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Services\ReportsService;
use App\Services\BasicInfoService;
use Illuminate\Support\Facades\Log;

class DownloadFileService{

    private $reportsService;
    private $basicInfoService;
    private $allGenders;
    private $allMaritalStatuses;
    private $allEducationTitles;
    private $allWorkTitles;
    private $allLegalStatuses;
    private $allLanguages;
    private $allLanguageLevels;
    private $allReferrals;

    public function __construct(){
        $this->reportsService = new ReportsService();
        $this->basicInfoService = new BasicInfoService();
        // make arrays with DB queries from functions inside the above or the present services
        $this->allGenders = $this->getAllGenders()->toArray();
        $this->allMaritalStatuses = $this->reportsService->getAllMaritalStatuses()->toArray();
        $this->allEducationTitles = $this->reportsService->getAllEducationTitles()->toArray();
        $this->allWorkTitles = $this->reportsService->getAllWorkTitles()->toArray();
        $this->allLegalStatuses = $this->reportsService->getAllLegalStatuses()->toArray();
        $this->allLanguages = $this->basicInfoService->getAllLanguages()->toArray();
        $this->allLanguageLevels = $this->basicInfoService->getAllLanguageLevels()->toArray();
        $this->allReferrals = $this->getAllReferrals()->toArray();
    }

    // make csv file
    public function makeCSVFileUsingBenefitersIds($idsString){
        $benefitersIds = $this->getBenefitersIdsArrayFromString($idsString);
        foreach($benefitersIds as $benefiterId){
            // make benefiter_id specific DB queries
            $benefiter = Benefiter::find($benefiterId);
            $benefiterLegalStatuses = \DB::table('benefiters_legal_status')->where('benefiter_id', '=', $benefiterId)->get();
            $benefiterLegalStatuses = $this->getBenefiterLegalStatusesFineArray($benefiterLegalStatuses);
            $benefiterLanguages = \DB::table('benefiters_languages')->where('benefiter_id', '=', $benefiterId)->get();
            $benefiterReferrals = \DB::table('benefiter_referrals')->where('benefiter_id', '=', $benefiterId)->get();
        }
    }

    // returns an array of ids from ids string
    private function getBenefitersIdsArrayFromString($idsString){
        return explode(',', $idsString);
    }

    // returns all the genders stored in the DB
    private function getAllGenders(){
        return \DB::table('genders_lookup')->get();
    }

    // returns all the referrals stored in DB
    private function getAllReferrals(){
        return \DB::table('benefiter_referrals_lookup')->get();
    }

    // get benefiter's legal statuses and transform the legal_status id to legal_status name
    private function getBenefiterLegalStatusesFineArray($benefiterLegalStatuses){
        if(!empty($benefiterLegalStatuses) and !empty($this->allLegalStatuses)) {
            $result = array();
            foreach ($benefiterLegalStatuses as $benefiterLegalStatus){
                $tmp = array();
                // try to find the legal status in DB result array
                try {
                    $legalStatusInfoFromLookup = $this->allLegalStatuses[$benefiterLegalStatus->legal_lookup_id];
                } catch (\Exception $e){ // out of bound exception
                    Log::error("Can't find the legal status requested.\n" . $e);
                    continue;
                }
                $tmp['legal_status'] = $legalStatusInfoFromLookup->description;
                $tmp['description'] = $benefiterLegalStatus->description;
                $tmp['exp_date'] = $benefiterLegalStatus->exp_date;
                array_push($result, $tmp);
            }
            return $result;
        } else {
            return null;
        }
    }
}
