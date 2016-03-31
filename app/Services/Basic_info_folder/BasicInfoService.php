<?php namespace App\Services\Basic_info_folder;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals_lookup;
use App\Services\Validation_services\Basic_info_folder\BasicInfoValdationService;
use App\Services\GreekStringConversionHelper;
use App\Services\DatesHelper;
use App\Services\Social_folder\BenefiterSocialFolderService;
use Validator;

class BasicInfoService{

    private $datesHelper;
    private $basic_info_validation;

    public function __construct(){
        // initialize dates helper
        $this->datesHelper = new DatesHelper();
        // initialize benefiter basic info validation
        $this->basic_info_validation = new BasicInfoValdationService();
    }

    // validate the basic info
    public function basicInfoValidation($request, $id){
        $this->basic_info_validation->basicInfoValidationService($request, $id);
    }

    // insert into DB benefiter table
    public function saveBasicInfoToDB($request){
        // if interpreter checkbox has no value, it should have '0' value
        if(!array_key_exists('interpreter' ,$request)){
            $request['interpreter'] = 0;
        }
        // get work title id from work title name
        $request['working_title'] = $this->getWorkTitleIdFromDBAndInsertNewWorkTitleIfNeeded($request['working_title']);
        $benefiter = new Benefiter(
            $this->getBenefiterArrayForDBInsert($request)
        );
        $benefiter->save();
        $languagesLevelsMerge = $this->mergeUniqueLanguagesLevelWithNoDuplicatedLanguageArrays($request);
        // if $languagesLevelsMerge is not an empty array, save them to DB
        if(!empty($languagesLevelsMerge)) {
            $this->saveLanguagesToDB($benefiter->id, $languagesLevelsMerge);
        }
        // if legal status is not existent, add it
        if(!array_key_exists('legal_status' ,$request)){
            $request['legal_status'] = null;
        }
        $this->saveLegalStatusesToDB($benefiter->id, $request);
        // initialize SocialFolderService to use the saveSocialFolderToDB function
        $socialService = new BenefiterSocialFolderService();
        $socialService->saveSocialFolderToDB(array('comments' => ''), $benefiter->id);
        return $benefiter;
    }

    // edit an already saved benefiter
    public function editBasicInfo($request, $id){
        // if interpreter checkbox has no value, it should have '0' value
        if(!array_key_exists('interpreter' ,$request)){
            $request['interpreter'] = 0;
        }
        // get work title id from work title name
        $request['working_title'] = $this->getWorkTitleIdFromDBAndInsertNewWorkTitleIfNeeded($request['working_title']);
        Benefiter::where('id', '=', $id)->update($this->getBenefiterArrayForDBInsert($request));
        $this->editLanguagesInDB($id, $this->mergeUniqueLanguagesLevelWithNoDuplicatedLanguageArrays($request));
//        $this->saveLanguagesToDB($id, $this->mergeUniqueLanguagesLevelWithNoDuplicatedLanguageArrays($request));
        // if legal status is not existent, add it
        if(!array_key_exists('legal_status' ,$request)){
            $request['legal_status'] = null;
        }
        $this->editLegalStatusesInDB($id, $request);
    }

    // get all languages from languages DB table
    public function getAllLanguages(){
        return \DB::table('languages')->get();
    }

    // get all language levels from language_levels DB table
    public function getAllLanguageLevels(){
        return \DB::table('language_levels')->get();
    }

    // finds a benefiter from its id
    public function findExistentBenefiter($id){
        return Benefiter::where('id', '=', $id)->with('gender')->first();
    }

    // gets all benefiter's legal statuses
    public function getLegalStatusesByBenefiterId($id){
        return \DB::table('benefiters_legal_status')->where('benefiter_id', '=', $id)->get();
    }

    // gets all benefiter's languages and languages levels
    public function getLanguagesAndLanguagesLevelsByBenefiterId($id){
        return \DB::table('benefiters_languages')->where('benefiter_id', '=', $id)->get();
    }

    // gets an array with legal statuses from request in case of validation failure
    public function getLegalStatusesArrayFromRequest($legal_statuses, $legal_texts, $legal_exp_dates){
        $temp = array();
        if($legal_statuses != null) {
            foreach ($legal_statuses as $legal_status) {
                array_push($temp, (object)$this->getLegalStatusArrayForValidationFailure($legal_status, $legal_texts[$legal_status - 1], $legal_exp_dates[$legal_status - 1]));
            }
        }
        return $temp;
    }

    // returns languages and levels input from request when validation fails
    public function getLanguagesAndLanguagesLevelsFromRequest($request){
        $languages_levels = $this->mergeUniqueLanguagesLevelWithNoDuplicatedLanguageArrays($request);
        for($i = 0; $i < count($languages_levels); $i++){
            $languages_levels[$i] = (object) $languages_levels[$i];
        }
        return $languages_levels;
    }

    // returns the work title name using the benefiter's id
    public function getWorkTitleNameFromBenefiterId($id){
        $benefiter = \DB::table('benefiters')->where('id' , '=', $id)->first();
        if ($benefiter != null) {
            $workTitle = \DB::table('work_title_list_lookup')->where('id', '=', $benefiter->work_title_id)->first();
            if ($workTitle != null){
                return $workTitle->work_title;
            }
        }
        return null;
    }

    // get all languages keys from basic info's form $request
    private function getLanguageKeysArray($request){
        // make an array with all languages keys
        $keys = array_keys($request);
        $languages = array();
        foreach($keys as $key){
            // check if string "language" is contained in array's keys
            if (strpos($key, "language") !== false && strpos($key, "language_level") === false){
                array_push($languages, $key);
            }
        }
        return $languages;
    }

    // deletes duplicate languages selected by user
    private function deleteDuplicatedLanguages($languagesKeys, $request){
        // make sure all languages selected are different
        $languages_id = array();
        foreach($languagesKeys as $language){
            // if this is not a language level
            if(strpos($language, "language_level") === false){
                $languages_id[$language] = $request[$language];
            }
        }
        return array_unique($languages_id);
    }

    // deletes duplicate languages selected by user
    private function getUniqueLanguagesLevels($languagesUnique, $request){
        // make sure you get all unique languages levels
        $keys = array_keys($languagesUnique);
        $languages_levels_id = array();
        foreach($keys as $key){
            $level_key = str_replace("language", "language_level", $key);
            $languages_levels_id[$key] = $request[$level_key];
        }
        return $languages_levels_id;
    }

    // merges the language and language level array with the deleted duplicates languages array
    private function mergeUniqueLanguagesLevelWithNoDuplicatedLanguageArrays($request){
        $languagesKeys = $this->getLanguageKeysArray($request);
        $languagesUnique = $this->deleteDuplicatedLanguages($languagesKeys, $request);
        $levelsUnique = $this->getUniqueLanguagesLevels($languagesUnique, $request);
        $keys = array_keys($languagesUnique);
        $merge = array();
        foreach($keys as $key){
            // if a correct language is selected
            if($languagesUnique[$key] != 1) {
                // if a non correct language level is selected, make it null
                if($levelsUnique[$key] == 1){
                    $levelsUnique[$key] = null;
                }
                // make array containing language id and level id and...
                $temp = array(
                    'language_id' => $languagesUnique[$key],
                    'language_level_id' => $levelsUnique[$key],
                );
                // ...push it into the $merge array
                array_push($merge, $temp);
            }
        }
        return $merge;
    }

    // make and return an array that will be appropriate for DB insert
    private function getBenefiterArrayForDBInsert($request){
        return array(
            "folder_number" => $request['folder_number'],
            "lastname" => $request['lastname'],
            "name" => $request['name'],
            "gender_id" => $request['gender_id'],
            "birth_date" => $this->datesHelper->makeDBFriendlyDate($request['birth_date']),
            "fathers_name" => $request['fathers_name'],
            "mothers_name" => $request['mothers_name'],
            "nationality_country" => $request['nationality_country'],
            "origin_country" => $request['origin_country'],
            "ethnic_group" => $request['ethnic_group'],
            "arrival_date" => $this->datesHelper->makeDBFriendlyDate($request['arrival_date']),
            "telephone" => $request['telephone'],
            "address" => $request['address'],
            "marital_status_id" => $request['marital_status'],
            "number_of_children" => $request['number_of_children'],
            "children_names" => $request['children_names'],
            "relatives_residence" => $request['relatives_residence'],
            "language_interpreter_needed" => $request['interpreter'],
            "education_id" => $request['education_status'],
            "is_benefiter_working" => $request['working'],
            "work_title_id" => $request['working_title'],
            "working_legally" => $request['working_legally'],
            "country_abandon_reason" => $request['country_abandon_reason'],
            "travel_route" => $request['travel_route'],
            "travel_duration" => $request['travel_duration'],
            "detention_duration" => $request['detention_duration'],
            "social_history" => $request['social_history'],
            "document_manager_id" => \Auth::user()->id,
        );
    }

    // save languages and languages level for benefiter with $benefiterId to DB
    private function saveLanguagesToDB($benefiterId, $languagesAndLevels){
        $languagesAndLevelsDBFriendly = $this->getLanguagesArrayForDBInsert($benefiterId, $languagesAndLevels);
        foreach($languagesAndLevelsDBFriendly as $languageAndLevel){
            \DB::table('benefiters_languages')->insert($languageAndLevel);
        }
    }

    // edit languages and languages level for benefiter with $benefiterId to DB
    private function editLanguagesInDB($benefiterId, $languagesAndLevels){
        $languagesAndLevelsDBFriendly = $this->getLanguagesArrayForDBInsert($benefiterId, $languagesAndLevels);
        $temp = \DB::table('benefiters_languages')->where('benefiter_id', '=', $benefiterId)->get();
        $ids_inserted = array();
        foreach($languagesAndLevelsDBFriendly as $languageAndLevel){
            $languageInserted = false;
            foreach($temp as $lang_in_db) {
                // if language and level already exist in DB update the row
                if($languageAndLevel['language_id'] == $lang_in_db->language_id){
                    \DB::table('benefiters_languages')->where('id', '=', $lang_in_db->id)->update($languageAndLevel);
                    array_push($ids_inserted, $languageAndLevel['language_id']);
                    $languageInserted = true;
                    break;
                }
            }
            // insert a new row
            if(!$languageInserted){
                \DB::table('benefiters_languages')->insert($languageAndLevel);
                array_push($ids_inserted, $languageAndLevel['language_id']);
            }
        }
        // delete all removed languages
        foreach($temp as $lang_in_db){
            $found = false;
            foreach($ids_inserted as $language_id){
                if($lang_in_db->language_id == $language_id){
                    $found = true;
                }
            }
            // if not found delete DB row
            if(!$found){
                \DB::table('benefiters_languages')->where('benefiter_id', '=', $benefiterId)->where('language_id', '=', $lang_in_db->language_id)->delete();
            }
        }
    }

    // edit legal statuses in DB
    private function editLegalStatusesInDB($benefiterId, $request){
        $legal_statuses_checked = $request['legal_status'];
        $temp = \DB::table('benefiters_legal_status')->where('benefiter_id', '=', $benefiterId)->get();
        $ids_inserted = array();
        if($legal_statuses_checked != null) {
            foreach ($legal_statuses_checked as $legal_status_checked) {
                $legalStatusInserted = false;
                foreach ($temp as $legal_status_db){
                    if($legal_status_db->legal_lookup_id == $legal_status_checked){
                        \DB::table('benefiters_legal_status')->where('id', '=', $legal_status_db->legal_lookup_id)->update($this->getLegalStatusArrayForDBInsert($benefiterId, intval($legal_status_checked), $request));
                        array_push($ids_inserted, $legal_status_checked);
                        $legalStatusInserted = true;
                        break;
                    }
                }
                if(!$legalStatusInserted) {
                    \DB::table('benefiters_legal_status')->insert($this->getLegalStatusArrayForDBInsert($benefiterId, intval($legal_status_checked), $request));
                }
            }
        }
        // delete all removed legal statuses
        foreach($temp as $legal_status_db){
            $found = false;
            foreach($ids_inserted as $legal_id){
                if($legal_status_db->legal_lookup_id == $legal_id){
                    $found = true;
                }
            }
            // if not found delete DB row
            if(!$found){
                \DB::table('benefiters_legal_status')->where('benefiter_id', '=', $benefiterId)->where('legal_lookup_id', '=', $legal_status_db->legal_lookup_id)->delete();
            }
        }
    }

    // returns array for benefiters_languages DB insertions
    private function getLanguagesArrayForDBInsert($benefiterId, $languagesAndLevels){
        $languagesForDB = array();
        foreach($languagesAndLevels as $languageAndLevel){
            // create a temp array with values needed and...
            $temp = array(
                'benefiter_id' => $benefiterId,
                'language_id' => $languageAndLevel['language_id'],
                'language_level_id' => $languageAndLevel['language_level_id'],
            );
            // ...push it into $languagesForDB
            array_push($languagesForDB, $temp);
        }
        return $languagesForDB;
    }

    // saves legal statuses for benefiter with $benefiterId to DB
    private function saveLegalStatusesToDB($benefiterId, $request){
        $legal_statuses_checked = $request['legal_status'];
        if($legal_statuses_checked != null) {
//            $this->makeLegalStatusDatesAndTextsArrays($request);
            foreach ($legal_statuses_checked as $legal_status_checked) {
                \DB::table('benefiters_legal_status')->insert($this->getLegalStatusArrayForDBInsert($benefiterId, intval($legal_status_checked), $request));
            }
        }
    }

    // returns an array for legal status DB table insert
    private function getLegalStatusArrayForDBInsert($benefiterId, $legal_status_checked, $request){
        return array(
            "benefiter_id" => $benefiterId,
            "exp_date" => $this->datesHelper->makeDBFriendlyDate($request['legal_status_exp_date'][$legal_status_checked - 1]),
            "description" => $request['legal_status_text'][$legal_status_checked - 1],
            "legal_lookup_id" => $legal_status_checked,
        );
    }

    // returns an array with the legal status from request in case of validation failure
    private function getLegalStatusArrayForValidationFailure($legal_status, $legal_text, $legal_exp_date){
        return array(
            "exp_date" => $this->datesHelper->getDateStringFromSimpleString($legal_exp_date),
            "description" => $legal_text,
            "legal_lookup_id" => $legal_status,
        );
    }

    // returns the work title id of a work title name
    private function getWorkTitleIdFromDBAndInsertNewWorkTitleIfNeeded($workTitleFromForm){
        // initialize the GreekStringConversionHelper service
        $greekStringConversion = new GreekStringConversionHelper();
        $workTitleId = null;
        $allWorkTitlesAvailable = \DB::table('work_title_list_lookup')->get();
        $workTitleFromForm = $greekStringConversion->grstrtoupper($workTitleFromForm);
        // if there are some work titles in DB
        if ($allWorkTitlesAvailable != null){
            // check for each one if the names are the same after greek string conversion to uppercase
            foreach($allWorkTitlesAvailable as $work_title){
                $work_title->work_title = $greekStringConversion->grstrtoupper($work_title->work_title);
                // if strings are the same set the $workTitleId to the DB's id
                if(strcasecmp($work_title->work_title, $workTitleFromForm) == 0){
                    $workTitleId = $work_title->id;
                    break;
                }
            }
        }
        // if work title was not found in DB
        if ($workTitleId == null) {
            $workTitleId = \DB::table('work_title_list_lookup')->insertGetId(array('work_title' => $workTitleFromForm));
        }
        return $workTitleId;
    }

    // ------------------------------------------------------------------ //
    //----------- benefter basic_info_referrals table (REFERRALS) --------//
    // DB save
    public function basic_info_referrals($request){
        $request_basic_info_referrals_id = $request['basic_info_referrals_id'];
        $request_basic_info_referrals_text = $request['basic_info_referrals_text'];
        $request_basic_info_referrals_date = $request['basic_info_referrals_date'];
        $benefiter_id = $request['benefiter_id'];

        // referrals added to be posted (same as text array and date array)
        $ref_number = count($request_basic_info_referrals_id);
        for($i=0 ; $i<$ref_number; $i++){
            $basic_info_referral = new BenefiterReferrals();
            $basic_info_referral->description = $request_basic_info_referrals_text[$i];
            $basic_info_referral->referral_date = $this->datesHelper->makeDBFriendlyDate($request_basic_info_referrals_date[$i]);
            $basic_info_referral->benefiter_id = $benefiter_id;
            $basic_info_referral->referral_lookup_id = $request_basic_info_referrals_id[$i];

            $basic_info_referral->save();
        }
    }
    // get all basic info referrals
    public function get_basic_info_referral(){
        $basic_info_referral_attributes = BenefiterReferrals::get()->all();
        return $basic_info_referral_attributes;
    }

    // get all referrals form lookup for benefiter's basic info
    public function get_basic_info_referrals_from_lookup(){
        $basic_info_referral = BenefiterReferrals_lookup::get()->all();
        return $basic_info_referral;
    }

    // get all referrals saved to db for this benefiter id
    public function get_referrals_for_a_benefiter($id){
        $benefiter_referrals_list = BenefiterReferrals::where('benefiter_id', $id)->with('referralType')->orderBy('referral_date', 'desc')->get();
        return $benefiter_referrals_list;
    }


    /*
     * public function deleteBasicInfoReferral($id, $referral_id){
     *     BenefiterReferrals::where('id', '=', $referral_id)->delete();
     * }
     */
}