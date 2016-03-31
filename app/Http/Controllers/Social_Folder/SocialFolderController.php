<?php

namespace App\Http\Controllers\Social_Folder;

use Illuminate\Http\Request;

// services used
use App\Services\Basic_info_folder\BasicInfoService;
use App\Services\Social_folder\BenefiterSocialFolderService;
use App\Services\Validation_services\Social_folder\BenefiterSocialFolderValidationService;


use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;

class SocialFolderController extends Controller{

    // services
    private $basicInfoService;
    private $socialFolderService;
    private $social_folder_validation_service;

    public function __construct(){
        // only for logged in users
        $this->middleware('activated');
        // initialize basic info service
        $this->basicInfoService = new BasicInfoService();
        // initialize social folder service
        $this->socialFolderService = new BenefiterSocialFolderService();
        // initialize social folder validation service
        $this->social_folder_validation_service = new BenefiterSocialFolderValidationService();
    }

    // get social folder view
    public function getSocialFolder($id){
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $psychologist_id = Auth::user()->id;
        // get psychosocial theme from session, else get null and afterwards forget session value
        $session_theme = session()->get('psychosocialTheme', function() { return null; });
        session()->forget('psychosocialTheme');
        $successMsg = session()->get('success', function() { return null; });
        session()->forget('success');
        if($benefiter == null) {
            return view('errors.404');
        } else {
            $socialFolder = $this->socialFolderService->getSocialFolderFromBenefiterId($id);
            $psychosocialSubjects = $this->socialFolderService->getAllPsychosocialSupportSubjects();
            if($socialFolder == null){
                return view('benefiter.social_folder')
                    ->with("tab", "social")
                    ->with("psychosocialSubjects", $psychosocialSubjects)
                    ->with("benefiter", $benefiter)
                    ->with("psychologist_id", $psychologist_id);
            } else {
                $benefiter_sessions = $this->socialFolderService->getAllSessionsFromBenefiterId($id);
                $psychosocialSupport = $this->socialFolderService->getBenefiterPsychosocialSupport($id);
                return view('benefiter.social_folder')
                    ->with("tab", "social")
                    ->with("psychosocialSubjects", $psychosocialSubjects)
                    ->with("benefiter", $benefiter)
                    ->with("social_folder", $socialFolder)
                    ->with("psychosocial_support", $psychosocialSupport)
                    ->with("psychologist_id", $psychologist_id)
                    ->with("session_theme", $session_theme)
                    ->with('benefiter_sessions', $benefiter_sessions)
                    ->with('success', $successMsg);
            }
        }
    }

    // post from social folder form
    public function postSocialFolder(Request $request, $id){
        $benefiter = $this->basicInfoService->findExistentBenefiter($id);
        $psychosocialSubjects = $this->socialFolderService->getAllPsychosocialSupportSubjects();
        $socialFolder = null;
        $psychosocialSupport = null;
        $validator = $this->social_folder_validation_service->socialFolderValidationService($request->all());
        if($validator->fails()){
            return redirect('benefiter/' . $id . '/social-folder')->with("tab", "social")->with("psychosocialSubjects", $psychosocialSubjects)->with("benefiter", $benefiter)->with("social_folder", $socialFolder)->with("psychosocial_support", $psychosocialSupport)->withErrors($validator->errors()->all());
        } else {
            $this->socialFolderService->saveSocialFolderToDB($request->all(), $id);
            $socialFolder = $this->socialFolderService->getSocialFolderFromBenefiterId($id);
            $psychosocialSupport = $this->socialFolderService->getBenefiterPsychosocialSupport($id);
            return redirect('benefiter/' . $id . '/social-folder')->with("tab", "social")->with("psychosocialSubjects", $psychosocialSubjects)->with("benefiter", $benefiter)->with("social_folder", $socialFolder)->with("psychosocial_support", $psychosocialSupport)->with('success', \Lang::get('records_controller_messages.social_folder_create_success'));
        }
    }

    // save a new session from social folder view
    public function postSessionSave(Request $request, $id){
        $validator = $this->social_folder_validation_service->sessionValidationService(array(
            'session_date' => $request->session_date,
            'session_comments' => $request->session_comments
        ));
        if($validator->fails()){
            return redirect('benefiter/'.$id.'/social-folder')
                ->withInput(array(
                    'session_comments' => $request->session_comments,
                    'session_date' => $request->session_date,
                ))
                ->with('psychosocialTheme', $request->psychosocial_theme)
                ->withErrors($validator->errors()->all());
        } else {
            $this->socialFolderService->saveNewSessionToDB($request->all(), $id);
            return redirect('benefiter/'.$id.'/social-folder')->with('success', \Lang::get('records_controller_messages.session_create_success'));
        }
    }

    // update an edited session
    public function postSessionEdit(Request $request, $id, $session_id){
        $validator = $this->social_folder_validation_service->sessionValidationService(array(
            'session_date' => $request->session_date,
            'session_comments' => $request->session_comments
        ));
        if($validator->fails()){
            return redirect('benefiter/'.$id.'/social-folder')
                ->withInput(array(
                    'session_comments' => $request->session_comments,
                    'session_date' => $request->session_date,
                ))
                ->with('psychosocialTheme', $request->psychosocial_theme)
                ->withErrors($validator->errors()->all());
        } else {
            $this->socialFolderService->saveEditedSessionToDB($request->all(), $session_id);
            return redirect('benefiter/'.$id.'/social-folder')->with('success', \Lang::get('records_controller_messages.session_edit_success'));
        }
    }

    // delete a session
    public function getSessionDelete($id, $session_id){
        $this->socialFolderService->deleteSessionById($session_id);
        return redirect("benefiter/" . $id . "/social-folder")->with('success', \Lang::get('records_controller_messages.session_delete_success'));
    }
}
