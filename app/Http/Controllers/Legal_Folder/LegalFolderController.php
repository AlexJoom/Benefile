<?php

namespace App\Http\Controllers\Legal_Folder;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// services used
use App\Services\Legal_folder\BenefiterLegalFolderService;
use App\Services\BasicInfoService;

class LegalFolderController extends Controller{

    private $legalFolderService;
    private $basicInfoService;

    public function __construct(){
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize legal folder service
        $this->legalFolderService = new BenefiterLegalFolderService();
    }

    // returns view of legal folder
    public function getLegalFolder($id){
        $legalFolder = $this->legalFolderService->findLegalFolderFromBenefiterId($id);
        $asylumRequest = null;
        $noLegalStatus = null;
        $lawyerActions = null;
        $successMsg = session()->get('success', function() { return null; });
        session()->forget('success');
        // if the legal folder exists return all things connected with it
        if($legalFolder != null){
            $asylumRequest = $this->legalFolderService->findAsylumRequestFromLegalFolderId($legalFolder->id);
            $noLegalStatus = $this->legalFolderService->findNoLegalStatusFromLegalFolderId($legalFolder->id);
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
            ->with('no_legal_status', $noLegalStatus)
            ->with('lawyer_action', $lawyerActions)
            ->with('tab', 'legal')
            ->with('success', $successMsg);
    }

    // gets data from legal folder form
    public function postLegalFolder(Request $request, $id){
        $validator = $this->legalFolderService->legalFolderValidator($request->all());
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
