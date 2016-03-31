<?php namespace App\Services\Social_folder;

use Validator;
use App\Models\PsychosocialSession;

use App\Services\DatesHelper;

class BenefiterSocialFolderService{

    private $datesHelper;

    public function __construct(){
        $this->datesHelper = new DatesHelper();
    }

    // saves the social folder in DB
    public function saveSocialFolderToDB($request, $benefiterId){
        if(!array_key_exists('psychosocial_statuses', $request)){
            $request['psychosocial_statuses'] = null;
        }
        $social_folder = \DB::table('social_folder')->where('benefiter_id', '=', $benefiterId)->first();
        if($social_folder == null) {
            \DB::table('social_folder')->insert($this->getSocialFolderArrayForDBInsert($request, $benefiterId));
        } else {
            \DB::table('social_folder')->where('benefiter_id', '=', $benefiterId)->update($this->getSocialFolderArrayForDBInsert($request, $benefiterId));
        }
    }

    // save a new session in DB
    public function saveNewSessionToDB($request, $benefiterId){
        $this->savePsychosocialSessionToDB($request, $this->getSocialFolderFromBenefiterId($benefiterId)->id);
    }

    // update an existing session in DB
    public function saveEditedSessionToDB($request, $session_id){
        PsychosocialSession::where('id', $session_id)->update($this->getPsychosocialSessionArrayForDBEdit($request));
    }

    // delete a session
    public function deleteSessionById($session_id){
        PsychosocialSession::where('id', '=', $session_id)->delete();
    }

    // gets all the rows from psychosocial_support_lookup DB table to display them in social folder view
    public function getAllPsychosocialSupportSubjects(){
        return \DB::table('psychosocial_support_lookup')->get();
    }

    // gets the social folder from benefiter's id
    public function getSocialFolderFromBenefiterId($id){
        return \DB::table('social_folder')->where('benefiter_id', '=', $id)->first();
    }

    // gets all benefiter's psychosocial support by benefiter id
    public function getBenefiterPsychosocialSupport($id){
        return \DB::table('benefiters_psychosocial_support')->where('benefiter_id', '=', $id)->get();
    }

    // gets all benefiter's sessions by benefiter id
    public function getAllSessionsFromBenefiterId($id){
        return PsychosocialSession::where('social_folder_id', '=', $this->getSocialFolderFromBenefiterId($id)->id)->orderBy('session_date', 'desc')->get();
    }

    // returns an array suitable for social_folder DB insertion
    private function getSocialFolderArrayForDBInsert($request, $benefiterId){
        return array(
            'benefiter_id' => $benefiterId,
            'comments' => $request['comments'],
        );
    }

    // saves the psychosocial support in DB
    private function savePsychosocialSupportToDB($request, $benefiterId){
        if($request['psychosocial_statuses'] != null){
            $psychosocialStatuses = $request['psychosocial_statuses'];
            foreach($psychosocialStatuses as $psychosocialStatus) {
                \DB::table('benefiters_psychosocial_support')->insert($this->getPsychosocialSupportArrayForDBInsert($psychosocialStatus, $benefiterId));
            }
        }
    }

    // gets array suitable for benefiters_psychosocial_support DB table insert
    private function getPsychosocialSupportArrayForDBInsert($psychosocialStatus, $benefiterId){
        return array(
            'psychosocial_support_id' => $psychosocialStatus,
            'benefiter_id' => $benefiterId,
        );
    }

    // saves a row to the psychosocial_sessions table in DB
    private function savePsychosocialSessionToDB($request, $socialFolderId){
        if(isset($request['session_date']) && isset($request['session_comments'])) {
            $psychosocialSession = new PsychosocialSession($this->getPsychosocialSessionArrayForDBInsert($request, $socialFolderId));
			$psychosocialSession->save();
        }
    }

    // gets array suitable for psychosocial_sessions DB table insertion
    private function getPsychosocialSessionArrayForDBInsert($request, $socialFolderId){
        $temp = $this->getPsychosocialSessionArrayForDBEdit($request);
        $temp['social_folder_id'] = $socialFolderId;
        $temp['psychologist_id'] = \Auth::user()->id;
        return $temp;
    }

    // get psychosocial session array for DB row edit
    private function getPsychosocialSessionArrayForDBEdit($request){
        return array(
            'session_date' => $this->datesHelper->makeDBFriendlyDate($request['session_date']),
            'psychosocial_theme_id' => $request['psychosocial_theme'],
            'session_comments' => $request['session_comments'],
        );
    }
}
