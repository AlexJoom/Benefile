<?php

namespace App\Http\Controllers\Benefiters_list;

use Illuminate\Http\Request;

// services used
use App\Services\Benefiters_list;
use App\Services\BasicInfoService;
use App\Services\Benefiters_list\BenefitersListService;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BenefitersListController extends Controller{

    // services
    private $benefitersList;

    public function __construct(){
        // only for logged in users
        $this->middleware('activated');
        // initialize benefiters list service
        $this->benefitersList = new BenefitersListService();
    }


    //------------ GET BENEFITERS LIST -------------------------------//

    // get all benefiters in a list
    public function getBenefitersList(){
        $benefiters =  $this->benefitersList->getAllBenefiters();
        return view('benefiter.benefiters_list', compact('benefiters'));
    }

    // delete a benefiter
    public function getDeleteBenefiter($id){
        $this->benefitersList->deleteBenefiter($id);
        return redirect('benefiters-list');
    }
}
