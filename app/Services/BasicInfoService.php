<?php namespace app\Services;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Services\DatesHelper;
use Validator;

class BasicInfoService{

    private $datesHelper;
    private $requestForValidation;
    private $legalDates = array();
    private $legalTexts = array();

    public function __construct(){
        // initialize dates helper
        $this->datesHelper = new DatesHelper();
    }

    // validate the basic info
    public function basicInfoValidation($request){
        $this->requestForValidation = $this->getValidationArray($request);
        return Validator::make($this->requestForValidation, array(
            'name' => 'max:255',
            'lastname' => 'max:255',
            'fathers_name' => 'max:255',
            'mothers_name' => 'max:255',
            'nationality_country' => 'max:255',
            'origin_country' => 'max:255',
            'birth_date' => 'date',
            'arrival_date' => 'date',
            'address' => 'max:255',
            'telephone' => 'digits:10',
            'number_of_children' => 'integer',
            'relatives_residence' => 'max:255',
            'legal_status_text0' => 'max:255',
            'legal_status_text1' => 'max:255',
            'legal_status_text2' => 'max:255',
            'legal_status_text3' => 'max:255',
            'legal_status_text4' => 'max:255',
            'legal_status_text5' => 'max:255',
            'legal_status_text6' => 'max:255',
            'legal_status_exp_date0' => 'date',
            'legal_status_exp_date1' => 'date',
            'legal_status_exp_date2' => 'date',
            'legal_status_exp_date3' => 'date',
            'legal_status_exp_date4' => 'date',
            'legal_status_exp_date5' => 'date',
            'legal_status_exp_date6' => 'date',
            'country_abandon_reason' => 'max:255',
            'travel_route' => 'max:255',
            'travel_duration' => 'max:255',
            'detention_duration' => 'max:255',
            'social_background' => 'max:2000',
        ));
    }

    // insert into DB benefiter table
    public function saveBasicInfoToDB($request){
        // if interpreter checkbox has no value, it should have '0' value
        if(!array_key_exists('interpreter' ,$request)){
           $request['interpreter'] = 0;
        }
        $benefiter = new Benefiter(
            $this->getBenefiterArrayForDBInsert($request)
        );
        $benefiter->save();
        $this->saveLanguagesToDB($benefiter->id, $this->mergeUniqueLanguagesLevelWithNoDuplicatedLanguageArrays($request));
        // if legal status is not existent, add it
        if(!array_key_exists('legal_status' ,$request)){
            $request['legal_status'] = null;
        }
        $this->saveLegalStatusesToDB($benefiter->id, $request);
        return $benefiter;
    }

    // get all languages from languages DB table
    public function getAllLanguages(){
        return \DB::table('languages')->get();
    }

    // get all language levels from language_levels DB table
    public function getAllLanguageLevels(){
        return \DB::table('language_levels')->get();
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
            // make array containing language id and level id and...
            $temp = array(
                'language' => $languagesUnique[$key],
                'level' =>$levelsUnique[$key],
            );
            // ...push it into the $merge array
            array_push($merge, $temp);
        }
        return $merge;
    }

    // make and return an array that will be appropriate for DB insert
    private function getBenefiterArrayForDBInsert($request){
        return array(
//             "folder_number" => $request['folder_name'],
            "lastname" => $request['lastname'],
            "name" => $request['name'],
            "gender_id" => $request['gender'],
            "birth_date" => $this->datesHelper->makeDBFriendlyDate($request['birth_date']),
            "fathers_name" => $request['fathers_name'],
            "mothers_name" => $request['mothers_name'],
            "nationality_country" => $request['nationality_country'],
            "origin_country" => $request['origin_country'],
            "arrival_date" => $this->datesHelper->makeDBFriendlyDate($request['arrival_date']),
            "telephone" => $request['telephone'],
            "address" => $request['address'],
            "marital_status_id" => $request['marital_status'],
            "number_of_children" => $request['number_of_children'],
            "relatives_residence" => $request['relatives_residence'],
            "language_interpreter_needed" => $request['interpreter'],
            "education_id" => $request['education_status'],
            "is_benefiter_working" => $request['working'],
            "working_legally" => $request['working_legally'],
            "country_abandon_reason" => $request['country_abandon'],
            "travel_route" => $request['travel_route'],
            "travel_duration" => $request['travel_duration'],
            "detention_duration" => $request['detention'],
            "social_background" => $request['social_background'],
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

    // returns array for benefiters_languages DB insertions
    private function getLanguagesArrayForDBInsert($benefiterId, $languagesAndLevels){
        $languagesForDB = array();
        foreach($languagesAndLevels as $languageAndLevel){
            // create a temp array with values needed and...
            $temp = array(
                'benefiter_id' => $benefiterId,
                'language_id' => $languageAndLevel['language'],
                'language_level_id' => $languageAndLevel['level'],
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
            $this->makeLegalStatusDatesAndTextsArrays();
            foreach ($legal_statuses_checked as $legal_status_checked) {
                \DB::table('benefiters_legal_status')->insert($this->getLegalStatusArrayForDBInsert($benefiterId, intval($legal_status_checked)));
            }
        }
    }

    // returns an array for legal status DB table insert
    private function getLegalStatusArrayForDBInsert($benefiterId, $legal_status_checked){
        return array(
            "benefiters_id" => $benefiterId,
            "exp_date" => $this->datesHelper->makeDBFriendlyDate($this->legalDates[$legal_status_checked - 1]),
            "description" => $this->legalTexts[$legal_status_checked - 1],
            "legal_lookup_id" => $legal_status_checked,
        );
    }

    // creates two arrays: an array for legal statuses dates and one for legal statuses texts
    private function makeLegalStatusDatesAndTextsArrays(){
        $keys = array_keys($this->requestForValidation);
        foreach($keys as $key){
            if(strpos($key, "legal_status_exp_date") !== false){
                array_push($this->legalDates, $this->requestForValidation[$key]);
            } elseif (strpos($key, "legal_status_text") !== false){
                array_push($this->legalTexts, $this->requestForValidation[$key]);
            }
        }
    }

    // returns an array suitable for validation
    private function getValidationArray($request){
        return array(
            //             "folder_number" => $request['folder_name'],
            "lastname" => $request['lastname'],
            "name" => $request['name'],
            "gender_id" => $request['gender'],
            "birth_date" => $this->datesHelper->makeDBFriendlyDate($request['birth_date']),
            "fathers_name" => $request['fathers_name'],
            "mothers_name" => $request['mothers_name'],
            "nationality_country" => $request['nationality_country'],
            "origin_country" => $request['origin_country'],
            "arrival_date" => $this->datesHelper->makeDBFriendlyDate($request['arrival_date']),
            "telephone" => $request['telephone'],
            "address" => $request['address'],
            "marital_status_id" => $request['marital_status'],
            "number_of_children" => $request['number_of_children'],
            "relatives_residence" => $request['relatives_residence'],
            "legal_status_text0" => $request['legal_status_text'][0],
            "legal_status_text1" => $request['legal_status_text'][1],
            "legal_status_text2" => $request['legal_status_text'][2],
            "legal_status_text3" => $request['legal_status_text'][3],
            "legal_status_text4" => $request['legal_status_text'][4],
            "legal_status_text5" => $request['legal_status_text'][5],
            "legal_status_text6" => $request['legal_status_text'][6],
            "legal_status_exp_date0" => $request['legal_status_exp_date'][0],
            "legal_status_exp_date1" => $request['legal_status_exp_date'][1],
            "legal_status_exp_date2" => $request['legal_status_exp_date'][2],
            "legal_status_exp_date3" => $request['legal_status_exp_date'][3],
            "legal_status_exp_date4" => $request['legal_status_exp_date'][4],
            "legal_status_exp_date5" => $request['legal_status_exp_date'][5],
            "legal_status_exp_date6" => $request['legal_status_exp_date'][6],
            "education_id" => $request['education_status'],
            "is_benefiter_working" => $request['working'],
            "working_legally" => $request['working_legally'],
            "country_abandon_reason" => $request['country_abandon'],
            "travel_route" => $request['travel_route'],
            "travel_duration" => $request['travel_duration'],
            "detention_duration" => $request['detention'],
            "social_background" => $request['social_background'],
            "document_manager_id" => \Auth::user()->id,
        );
    }
}
