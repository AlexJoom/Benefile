<?php
/**
 * Created by PhpStorm.
 * User: cdimitzas
 * Date: 31/3/2016
 * Time: 5:09 μμ
 */

namespace App\Services\Benefiters_list;

// services used
use App\Services\DatesHelper;

use App\Models\Benefiters_Tables_Models\Benefiter;
use Validator;

class BenefitersListService {

    private $datesHelper;

    public function __construct(){
        // initialize dates helper
        $this->datesHelper = new DatesHelper();
    }

    // get all benefiters from DB
    public function getAllBenefiters(){
        $benefitersList = Benefiter::with('educationLookup', 'medical_visits')->get();
        return $benefitersList;
    }

    // delete a benefiter from his id
    public function deleteBenefiter($benefiterId){
        $benefiter = Benefiter::where('id', '=', $benefiterId)->first();
        $benefiter->folder_number = $this->datesHelper->getCurrentTimeString() . "_" . $benefiter->folder_number;
        $benefiter->save();
        Benefiter::where('id', '=', $benefiterId)->delete();
    }
} 