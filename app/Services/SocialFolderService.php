<?php namespace app\Services;

use Validator;

class SocialFolderService{

    // validates the social folder view form input
    public function socialFolderValidation($request){
        return Validator::make($request, array(
            // 'children_names' => 'max:255',
            'comments' => 'max:2000',
            'session_date' => 'date',
            'session_comments' => 'max:2000',
        ));
    }

    // saves the social folder in DB
    public function saveSocialFolderToDB($request, $benefiterId){
        if(!array_key_exists('psychosocial_statuses', $request)){
            $request['psychosocial_statuses'] = null;
        }
        $socialFolderId = \DB::table('social_folder')->insertGetId($this->getSocialFolderArrayForDBInsert($request, $benefiterId));
        $this->savePsychosocialSupportToDB($request, $benefiterId);
        $this->savePsychosocialSessionToDB($request, $socialFolderId);
    }

    // gets all the rows from psychosocial_support_lookup DB table to display them in social folder view
    public function getAllPsychosocialSupportSubjects(){
        return \DB::table('psychosocial_support_lookup')->get();
    }

    // gets the social folder from benefiter's id
    public function getSocialFolderFromBenefiterId($id){
        return \DB::table('social_folder')->where('benefiter_id', '=', $id)->first();
    }

    //
    public function getBenefiterPsychosocialSupport($id){
        return \DB::table('benefiters_psychosocial_support')->where('benefiter_id', '=', $id)->get();
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
            \DB::table('psychosocial_sessions')->insert($this->getPsychosocialSessionArrayForDBInsert($request, $socialFolderId));
        }
    }

    // gets array suitable for psychosocial_sessions DB table insertion
    private function getPsychosocialSessionArrayForDBInsert($request, $socialFolderId){
        $datesHelper = new DatesHelper();
        return array(
            'social_folder_id' => $socialFolderId,
            'session_date' => $datesHelper->makeDBFriendlyDate($request['session_date']),
            'session_comments' => $request['session_comments'],
            'psychosocial_theme_id' => $request['psychosocial_theme'],
            'psychologist_id' => \Auth::user()->id,
        );
    }
}
