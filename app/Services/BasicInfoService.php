<?php namespace app\Services;

use App\Models\Benefiters_Tables_Models\Benefiter;
use Validator;

class BasicInfoService{

    // validate the basic info
    public function basicInfoValidation($request){
        return Validator::make($this->getValidationArray($request), array(
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
        $benefiter = new Benefiter();
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
                return $day.'.'.$month.'.'.$year;
            }
        }
        return null;
    }

    // if date is text make its format valid for validation
    private function makeDateFormatValid($date){
        $date = str_replace('/', '.', $date);
        $date = str_replace('-', '.', $date);
        return $date;
    }

    // make an array, appropriate for validating purposes
    private function getValidationArray($request){
        $birth_date = $this->makeDateStringFromStrings($request->birth_day, $request->birth_month, $request->birth_year);
        $arrival_date = $this->makeDateFormatValid($request->arrival_date);
        $deportation_date = $this->makeDateStringFromStrings($request->deportation_day, $request->deportation_month, $request->deportation_year);
        $asylum_date = $this->makeDateStringFromStrings($request->asylum_day, $request->asylum_month, $request->asylum_year);
        $refugee_date = $this->makeDateStringFromStrings($request->refugee_day, $request->refugee_month, $request->refugee_year);
        $editedInput = array(
            'birth_date' => $birth_date,
            'arrival_date' => $arrival_date,
            'deportation_date' => $deportation_date,
            'asylum_date' => $asylum_date,
            'refugee_date' => $refugee_date,
        );
        return $editedInput;
    }
}
