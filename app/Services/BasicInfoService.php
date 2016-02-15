<?php namespace app\Services;

use App\Models\Benefiters_Tables_Models\Benefiter;
use Validator;
use Carbon\Carbon;

class BasicInfoService{

    // validate the basic info
    public function basicInfoValidation($request){
//        $this->getValidationArray($request);
        return Validator::make($request, array(
            'birth_date' => 'date',
            'arrival_date' => 'date',
            'number_of_children' => 'integer',
            'deportation_date' => 'date',
            'asylum_date' => 'date',
            'refugee_date' => 'date',
            'residence_permit_date' => 'date',
            'immigrant_residence_permit_date' => 'date',
            'european_date' => 'date',
            'out_of_legal_date' => 'date',
        ));
    }

    // insert into DB benefiter table
    public function saveBasicInfoToDB($request){
        $benefiter = new Benefiter(
            $this->getBenefiterArrayForDBInsert($request)
        );
        $benefiter->save();
        $this->saveLanguagesToDB($benefiter->id, $this->mergeUniqueLanguagesLevelWithNoDuplicatedLanguageArrays($request));
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

    // get valid date for DB use from date String
    private function makeDBFriendlyDate($date){
        if($date != null) {
            $day = strtok($date, "-");
            $month = strtok("-");
            $year = strtok("-");
            return Carbon::createFromDate($year, $month, $day);
        } else {
            return "";
        }
    }

    // make and return an array that will be appropriate for DB insert
    private function getBenefiterArrayForDBInsert($request){
        return array(
//             "folder_number" => $request['folder_name'],
            "lastname" => $request['lastname'],
            "name" => $request['name'],
            "gender_id" => $request['gender'],
            "birth_date" => $this->makeDBFriendlyDate($request['birth_date']),
            "fathers_name" => $request['fathers_name'],
            "mothers_name" => $request['mothers_name'],
            "nationality_country" => $request['nationality_country'],
            "origin_country" => $request['origin_country'],
            "arrival_date" => $this->makeDBFriendlyDate($request['arrival_date']),
            "telephone" => $request['telephone'],
            "address" => $request['address'],
            "marital_status_id" => $request['marital_status'],
            "number_of_children" => $request['number_of_children'],
            "relatives_residence" => $request['relatives_residence'],
            "language_interpreter_needed" => $request['interpreter'],
//            "deportation" => $request['deportation'],
//            "deportation_date" => $request['deportation_date'],
//            "asylum_application" => $request['asylum_application'],
//            "asylum_date" => $request['asylum_date'],
//            "refugee" => $request['refugee'],
//            "refugee_date" => $request['refugee_date'],
//            "residence_permit" => $request['residence_permit'],
//            "residence_permit_date" => $request['residence_permit_date'],
//            "immigrant_residence_permit" => $request['immigrant_residence_permit'],
//            "immigrant_residence_permit_date" => $request['immigrant_residence_permit_date'],
//            "european" => $request['european'],
//            "european_date" => $request['european_date'],
//            "out_of_legal" => $request['out_of_legal'],
//            "out_of_legal_date" => $request['out_of_legal_date'],
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
}
