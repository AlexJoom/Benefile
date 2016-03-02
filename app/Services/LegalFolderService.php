<?php namespace App\Services;

use App\Services\DatesHelper;
use Validator;

class LegalFolderService{

    private $datesHelper;

    public function __construct(){
        // initialize DatesHelper
        $this->datesHelper = new DatesHelper();
    }

    // validation for legal folder form
    public function legalFolderValidator($request){
        return Validator::make($request,
            array(
                'asylum_request_date' => 'date',
                'request_progress' => 'max:2000',
                'penalty_text' => 'max:2000',
            )
        );
    }

    // save legal folder form's input in DB
    public function saveLegalFolderToDB($request, $id){
        // if lawyer_action is not existent, add it
        if(!array_key_exists('lawyer_action' ,$request)){
            $request['lawyer_action'] = null;
        }
        $legalFolderId = \DB::table('legal_folder')->insertGetId($this->getLegalFolderArrayForDBInsert($request['legal_folder_status'], $request['penalty'], $request['penalty_text'], $id));
        // check if a new asylum_request row should be inserted or...
        if ($request['legal_folder_status'] == '1'){
            \DB::table('asylum_request')->insert($this->getAsylumRequestArrayForDBInsert($request['asylum_request_date'], $request['procedure'], $request['request_status'], $request['request_progress'], $legalFolderId));
        } else{ // ...a new no_legal_status row
            \DB::table('no_legal_status')->insert($this->getNoLegalStatusArrayForDBInsert($request['action'], $request['result'], $legalFolderId));
        }
        $this->saveLawyerActionsToDB($request['lawyer_action'], $legalFolderId);
    }

    // gets legal folder using the benefiter's id
    public function findLegalFolderFromBenefiterId($benefiterId){
        return \DB::table('legal_folder')->where('benefiter_id', '=', $benefiterId)->first();
    }

    // gets asylum request using the legal folder's id
    public function findAsylumRequestFromLegalFolderId($legalFolderId){
        return \DB::table('asylum_request')->where('legal_folder_id', '=', $legalFolderId)->first();
    }

    // gets no legal status using the legal folder's id
    public function findNoLegalStatusFromLegalFolderId($legalFolderId){
        return \DB::table('no_legal_status')->where('legal_folder_id', '=', $legalFolderId)->first();
    }

    // gets gets lawyer actions using the legal folder's id
    public function findLawyerActionsFromLegalFolderId($legalFolderId){
        return \DB::table('legal_lawyer_action')->where('legal_folder_id', '=', $legalFolderId)->get();
    }

    // returns an array suitable for legal_folder DB table insert
    private function getLegalFolderArrayForDBInsert($legalFolderStatus, $penalty, $penaltyText, $id){
        $penaltyText = ($penalty == '1') ? $penaltyText : "";
        return array(
            'benefiter_id' => $id,
            'legal_folder_status_id' => $legalFolderStatus,
            'penalty_id' => $penalty,
            'penalty_text' => $penaltyText,
        );
    }

    // returns an array suitable for asylum_request DB table insert
    private function getAsylumRequestArrayForDBInsert($request_date, $procedure, $request_status, $request_progress, $legalFolderId){
        if($procedure == '1'){
            $request_status = null;
        }
        return array(
            'request_date' => $this->datesHelper->makeDBFriendlyDate($request_date),
            'procedure_id' => $procedure,
            'request_status_id' => $request_status,
            'request_progress' => $request_progress,
            'legal_folder_id' => $legalFolderId,
        );
    }

    // returns an array suitable for no_legal_status DB table insert
    private function getNoLegalStatusArrayForDBInsert($action, $result, $legalFolderId){
        if($action == '1'){
            $result = null;
        }
        return array(
            'action_id' => $action,
            'result_id' => $result,
            'legal_folder_id' => $legalFolderId,
        );
    }

    // saves lawyer actions in legal_lawyer_action DB table
    private function saveLawyerActionsToDB($lawyer_actions, $legalFolderId){
        if($lawyer_actions != null) {
            foreach ($lawyer_actions as $lawyer_action) {
                \DB::table('legal_lawyer_action')->insert(
                    array(
                        'lawyer_action_id' => $lawyer_action,
                        'legal_folder_id' => $legalFolderId,
                    )
                );
            }
        }
    }
}
