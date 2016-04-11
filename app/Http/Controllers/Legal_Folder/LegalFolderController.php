<?php

namespace App\Http\Controllers\Legal_Folder;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// services used
use App\Services\Legal_folder\BenefiterLegalFolderService;
use App\Services\Validation_services\Legal_folder\LegalFolderValidationService;
use App\Services\Basic_info_folder\BasicInfoService;

class LegalFolderController extends Controller{

    private $legalFolderService;
    private $basicInfoService;
    private $legal_folder_validation;


    public function __construct(){
        // only for logged in users
        $this->middleware('activated');
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize legal folder service
        $this->legalFolderService = new BenefiterLegalFolderService();
        // initialize legal folder validation service
        $this->legal_folder_validation = new LegalFolderValidationService();
    }

    // returns view of legal folder
    public function getLegalFolder($id){
        $legalFolder = $this->legalFolderService->findLegalFolderFromBenefiterId($id);
        $asylumRequest = null;
        $legal_status = null;
        $lawyerActions = null;
        $successMsg = session()->get('success', function() { return null; });
        session()->forget('success');
        // if the legal folder exists return all things connected with it
        if($legalFolder != null){
            $asylumRequest = $this->legalFolderService->findAsylumRequestFromLegalFolderId($legalFolder->id);
            $legal_status = $this->legalFolderService->findLegalSectionStatusFromLegalFolderId($legalFolder->id);
            $lawyerActions = $this->legalFolderService->findLawyerActionsFromLegalFolderId($legalFolder->id);
        }
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        if($benefiter == null){
            return view('errors.404');
        }
        return view('benefiter.legal_folder')
            ->with('legal_folder', $legalFolder)
            ->with('benefiter', $benefiter)
            ->with('asylum_request', $asylumRequest)
            ->with('legal_status', $legal_status)
            ->with('lawyer_action', $lawyerActions)
            ->with('tab', 'legal')
            ->with('success', $successMsg);
    }

    // gets data from legal folder form
    public function postLegalFolder(Request $request, $id){
        $validator = $this->legal_folder_validation->legalFolderValidatorService($request->all());
        if ($validator->fails()){
            return redirect('benefiter/'.$id.'/legal-folder')
                ->withInput($request->all())
                ->withErrors($validator->errors()->all());
        } else {
            $this->legalFolderService->saveLegalFolderToDB($request->all(), $id);
            return redirect('benefiter/'.$id.'/legal-folder')->with('success', \Lang::get('records_controller_messages.legal_folder_create_success'));
        }
    }
}
