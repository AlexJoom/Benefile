<?php namespace app\Services;

use App\Models\Benefiters_Tables_Models\Benefiter;
use Validator;
use Carbon\Carbon;

class BasicInfoService{

    private $editedInput;

    // validate the basic info
    public function basicInfoValidation($request){
        $this->getValidationArray($request);
        return Validator::make($this->editedInput, array(
            'birth_date' => 'date',
            'arrival_date' => 'date',
            'deportation_date' => 'date',
            'asylum_date' => 'date',
            'refugee_date' => 'date',
        ));
    }

    // insert into DB benefiter table
    public function saveBasicInfoToDB($request){
        $languagesAndLevels = $this->mergeUniqueLanguagesLevelWithNoDuplicatedLanguageArrays($request);
        // do stuff with $languagesAndLevels
        $benefiter = new Benefiter(
            $this->getArrayForDBInsert($request)
        );
        $benefiter->save();
    }

    // get all languages keys from basic info's form $request
    private function getLanguageKeysArray($request){
        // make an array with all languages keys
        $keys = array_keys($request->request->all());
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
                $languages_id[$language] = $request->$language;
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
            $languages_levels_id[$key] = $request->$level_key;
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

    // gets $day, $month, $year and returns a String with the date correctly formatted or null
    private function makeDateStringFromStrings($day, $month, $year){
        if($day != null && $month != null && $year != null){
            if(is_numeric($day) && is_numeric($month) && is_numeric($year)){
                return $day.'-'.$month.'-'.$year;
            }
        }
        return null;
    }

    // if date is text make its format valid for validation
    private function makeDateStringFormatValid($date){
        $date = str_replace('/', '-', $date);
        return $date;
    }

    // make an array, appropriate for validating purposes
    private function getValidationArray($request){
        $birth_date = $this->makeDateStringFromStrings($request->birth_day, $request->birth_month, $request->birth_year);
        $arrival_date = $this->makeDateStringFormatValid($request->arrival_date);
        $deportation_date = $this->makeDateStringFromStrings($request->deportation_day, $request->deportation_month, $request->deportation_year);
        $asylum_date = $this->makeDateStringFromStrings($request->asylum_day, $request->asylum_month, $request->asylum_year);
        $refugee_date = $this->makeDateStringFromStrings($request->refugee_day, $request->refugee_month, $request->refugee_year);
        $this->editedInput = array(
            'birth_date' => $birth_date,
            'arrival_date' => $arrival_date,
            'deportation_date' => $deportation_date,
            'asylum_date' => $asylum_date,
            'refugee_date' => $refugee_date,
        );
    }

//    private function getDateFromStrings($day, $month, $year){
//        return Carbon::createFromDate($year, $month, $day);
//    }

    // get Date from Date String
//    private function getDateFromDateString($dateString){
//        $day = strtok($dateString, ".");
//        $month = strtok(".");
//        $year = strtok(".");
//        return Carbon::createFromDate($year, $month, $day);
//    }

    // get valid date for DB use from date String
    public function makeDBFriendlyDate($date){
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
    private function getArrayForDBInsert($request){
        return array(
            "lastname" => $request->lastname,
            "name" => $request->name,
            "gender_id" => $request->gender,
            "birth_date" => $this->makeDBFriendlyDate($this->editedInput['birth_date']),
            "fathers_name" => $request->fathers_name,
            "mothers_name" => $request->mothers_name,
            "nationality_country" => $request->nationality_country,
            "origin_country" => $request->origin_country,
            "arrival_date" => $this->makeDBFriendlyDate($this->editedInput['arrival_date']),
            "telephone" => $request->telephone,
            "address" => $request->address,
            "marital_status_id" => $request->marital_status_id,
            "number_of_children" => $request->number_of_children,
            "relatives_residence" => $request->relatives_residence,
//            "deportation" => $request->,
//            "deportation_day" => $request->,
//            "deportation_month" => $request->,
//            "deportation_year" => $request->,
//            "asylum_application" => $request->,
//            "asylum_day" => $request->,
//            "asylum_month" => $request->,
//            "asylum_year" => $request->,
//            "refugee" => $request->,
//            "refugee_day" => $request->,
//            "refugee_month" => $request->,
//            "refugee_year" => $request->,
            "education_id" => $request->education_status,
            "is_benefiter_working" => $request->working,
            "working_legally" => $request->working_legally,
            "country_abandon_reason" => $request->country_abandon,
            "travel_route" => $request->travel_route,
            "travel_duration" => $request->travel_duration,
            "detention_duration" => $request->detention,
        );
    }

    // get all languages from languages DB table
    public function getAllLanguages(){
        return \DB::table('languages')->get();
    }

    // get all language levels from language_levels DB table
    public function getAllLanguageLevels(){
        return \DB::table('language_levels')->get();
    }
}
