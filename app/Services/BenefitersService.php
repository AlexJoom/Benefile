<?php namespace app\Services;

use App\Models\Benefiters_Tables_Models\Benefiter;
use Validator;

class BenefitersService{

    public function getAllBenefiters(){
        $benefitersList = Benefiter::with('educationLookup', 'medical_visits', 'medical_examinations')->get();
        return $benefitersList;
    }
}