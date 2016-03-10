<?php namespace App\Services;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\File_import_schema;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals_lookup;
use App\Services\ConversionsForFileUpload;
use App\Services\DatesHelper;
use App\Services\GreekStringConversionHelper;

class UploadFileService{

    private $__langNames = array();
    private $__levelNames = array();

    public function __construct(){
        $this->greekStringConversion = new GreekStringConversionHelper();
    }

    // inserts all values to DB
    public function fileImport($filePath){
        header('Content-Type: text/html; charset=UTF-8');
        // Call benefiter table in db
        $file_import_Fields = ['id',
            'folder_number', 'name', 'lastname', 'fathers_name', 'mothers_name', 'gender', 'origin_country',
            'nationality_country', 'birth_date', 'arrival_date', 'address', 'telephone', 'marital_status',
            'number_of_children', 'relatives_residence', 'legal_status', 'legal_status_details', 'legal_status_exp_date',
            'education', 'language', 'language_level', 'other_language', 'language_interpreter_needed', 'is_benefiter_working',
            'work_title', 'working_legally',
            'country_abandon_reason', 'travel_route', 'travel_duration', 'detention_duration', 'has_social_reference',
            'social_reference_actions', 'social_reference_date', 'has_medical_reference', 'medical_reference_actions',
            'medical_reference_date', 'has_legal_reference', 'legal_reference_actions', 'legal_reference_date',
            'has_educational_reference', 'educational_reference_actions', 'educational_reference_date', 'social_history'
        ];

        // Import csv
        $csvFile = file($filePath);
        // Iterate between all rows of the csv file and add each value to the benefiters table
        for($i=1; $i<count($csvFile); $i++) {
            $colValues = str_getcsv( $csvFile[$i]);
            $file_import = new File_import_schema();
            for($j=1; $j<count($colValues); $j++){
                $file_import->$file_import_Fields[$j] = $colValues[$j];
            }
            try {
                $file_import->save();
            } catch (\Exception $e){
                // TODO: add translation for message.
                return ("Cvs upload error.");
            }
        }
        $this->selectAppropriateDBTableForEachFileRowColumns();
    }

    // selects the appropriate DB table for each column of a row
    private function selectAppropriateDBTableForEachFileRowColumns(){
        $allFileRows = File_import_schema::get();
        if($allFileRows != null) {
            foreach ($allFileRows as $singleRow) {
                try {
                    $id = Benefiter::insertGetId($this->selectBenefitersColumnsAndValuesFromFileRow($singleRow));
                    $this->insertLanguagesToDBFromFile($singleRow->language, $singleRow->language_level, $id);
                    $imported_benefiter_id = \DB::table('benefiters')->insertGetId($this->selectBenefitersColumnsAndValuesFromFileRow($singleRow));
                    $this->importReferrals($singleRow, $imported_benefiter_id);
                } catch(\Exception $e) {
                    // do nothing
                }

//                $benefiterReferralsColumns = $this->selectBenefitersReferralsColumnsAndValuesFromFileRow($singleRow);
            }
        }
    }

    // selects and returns all the columns - values inserted from file that correspond to the benefiters DB table
    private function selectBenefitersColumnsAndValuesFromFileRow($singleRow){
        $datesHelper = new DatesHelper();
        $conversionForFile = new ConversionsForFileUpload();
        $singleRow->gender = $conversionForFile->getGenderId($singleRow->gender);
        $singleRow->marital_status = $conversionForFile->getMaritalStatusId($singleRow->marital_status);
        $singleRow->education = $conversionForFile->getEducationId($singleRow->education);
        $singleRow->language_interpreter_needed = $conversionForFile->getYesOrNoId($singleRow->language_interpreter_needed);
        $singleRow->is_benefiter_working = $conversionForFile->getYesOrNoId($singleRow->is_benefiter_working);
        $singleRow->working_legally = $conversionForFile->getLegalWorkId($singleRow->working_legally);
        $singleRow->origin_country = $conversionForFile->getOriginCountry($singleRow->origin_country);
        $singleRow->nationality_country = $conversionForFile->getNationalityCountry($singleRow->nationality_country);
        return array(
            'folder_number' => $singleRow->folder_number,
            'name' => $singleRow->name,
            'lastname' => $singleRow->lastname,
            'fathers_name' => $singleRow->fathers_name,
            'mothers_name' => $singleRow->mothers_name,
            'birth_date' => $datesHelper->makeDBFriendlyDate($singleRow->birth_date),
            'arrival_date' => $datesHelper->makeDBFriendlyDate($singleRow->arrival_date),
            'gender_id' => $singleRow->gender,
            'origin_country' => $singleRow->origin_country,
            'nationality_country' => $singleRow->nationality_country,
            'address' => $singleRow->address,
            'telephone' => $singleRow->telephone,
            'marital_status_id' => $singleRow->marital_status,
            'number_of_children' => $singleRow->number_of_children,
            'relatives_residence' => $singleRow->relatives_residence,
            'education_id' => $singleRow->education,
            'language_interpreter_needed' => $singleRow->language_interpreter_needed,
            'is_benefiter_working' => $singleRow->is_benefiter_working,
//                'work_title_id' => $singleRow->work_title,// make it id
            'working_legally' => $singleRow->working_legally,
            'country_abandon_reason' => $singleRow->country_abandon_reason,
            'travel_route' => $singleRow->travel_route,
            'travel_duration' => $singleRow->travel_duration,
            'detention_duration' => $singleRow->detention_duration,
            'social_history' => $singleRow->social_history,
            'document_manager_id' => \Auth::user()->id,
        );
    }




    // ---------------------------------------------------------------------------------- //
    // for current imported benefiter add the respective referrals, from csv, to DB tables
    public function importReferrals($singleRow, $benefiter_id){
        // all fields will come with this way but
        $referralsFileRows = File_import_schema::get();
        // referrals lookup ids
        $social_referrence_lookup_id = BenefiterReferrals_lookup::where('description', 'LIKE', '%οινων%')->first()->id;
        $medical_referrence_lookup_id = BenefiterReferrals_lookup::where('description', 'LIKE', '%ατρικ%')->first()->id;
        $legal_referrence_lookup_id = BenefiterReferrals_lookup::where('description', 'LIKE', '%ομικ%')->first()->id;
        $educational_referrence_lookup_id = BenefiterReferrals_lookup::where('description', 'LIKE', '%δευση%')->first()->id;

//        if($referralsFileRows != null) {
//            foreach ($referralsFileRows as $singleRow) {
//                try {
                    // if social referral
                    if($this->greekStringConversion->grstrtoupper($singleRow->has_social_reference) == 'ΝΑΙ') {
                        BenefiterReferrals::insert($this->selectOnlyReferrals($singleRow->social_reference_actions,
                                                                                $singleRow->social_reference_date, $benefiter_id, $social_referrence_lookup_id));
                    }
                    // if medical referral
                    if($this->greekStringConversion->grstrtoupper($singleRow->has_medical_reference) == 'ΝΑΙ'){
                        BenefiterReferrals::insert($this->selectOnlyReferrals($singleRow->medical_reference_actions,
                                                                                $singleRow->medical_reference_date, $benefiter_id, $medical_referrence_lookup_id));
                    }
                    // if legal referral
                    if($this->greekStringConversion->grstrtoupper($singleRow->has_legal_reference) == 'ΝΑΙ') {
                        BenefiterReferrals::insert($this->selectOnlyReferrals($singleRow->legal_reference_actions,
                                                                                $singleRow->legal_reference_date, $benefiter_id, $legal_referrence_lookup_id));
                    }
                    // if educational referral
                    if($this->greekStringConversion->grstrtoupper($singleRow->has_educational_reference) == 'ΝΑΙ') {
                        BenefiterReferrals::insert($this->selectOnlyReferrals($singleRow->educational_reference_actions,
                                                                                $singleRow->educational_reference_date, $benefiter_id, $educational_referrence_lookup_id));
                    }
//                } catch(\Exception $e) {
//                    // do nothing
//                }
//            }
//        }
    }

    // select the appropriate table columns for referrals and return them as an array
    public function selectOnlyReferrals($description, $referral_date, $benefiter_id, $referral_type_id){
        $datesHelper = new DatesHelper();
        $referralDb = array('description' => $description,
                            'referral_date' => $datesHelper->makeDBFriendlyDate($referral_date),
                            'benefiter_id' => $benefiter_id,
                            'referral_lookup_id' => $referral_type_id);
        return $referralDb;
    }

    // inserts languages to DB
    private function insertLanguagesToDBFromFile($languages, $languages_levels, $id){
        $languagesAndLevels = $this->getLanguagesArrayForDBInsert($languages, $languages_levels, $id);
        foreach($languagesAndLevels as $languageAndLevel){
            \DB::table('benefiters_languages')->insert($languageAndLevel);
        }
    }

    // check whether language exists in array. Returns the ID of an existing language,
    // or a NEW ID if the language did not exist in the DB
    private function getLanguageID($sLang) {
        // If I have NOT already loaded the language strings
        if(empty($this->__langNames)) {
            // Get all language codes from DB
            $allLanguages = \DB::table('languages')->get();
            // For every language code
            foreach($allLanguages as $language) {
                // Look-up in resources
                // Normalize
                // Add to __langNames
                $this->__langNames[$language->id] = $this->greekStringConversion->grstrtoupper(\Lang::get('language_list.'.$language->description));
            }
        }
        // else
            // use as is

        // Normalize $sLang
        $tmp = $this->greekStringConversion->grstrtoupper($sLang);
        // Check whether lang exists in the DB
        $id = array_search($tmp, $this->__langNames);
        // If it exists
            // Simply use existing ID
        // else
        if(!$id){
            $id = null;
        }
        // TODO: Determine whether we want to simply output error if not in DB
        // return the ID
        return $id;
    }

    // gets the language level id from level name
    private function getLanguageLevelID($sLevel) {
        // If I have NOT already loaded the level strings
        if(empty($this->__levelNames)) {
            // Get all levels from DB
            $allLevels = \DB::table('language_levels')->get();
            // For every level
            foreach($allLevels as $level) {
                // Normalize
                // Add to __levelNames
                $this->__levelNames[$level->id] = $this->greekStringConversion->grstrtoupper($level->description);
            }
        }
        // else
            // use as is

        // Normalize $sLevel
        $tmp = $this->greekStringConversion->grstrtoupper($sLevel);
        // Check whether level exists in the DB
        $id = array_search($tmp, $this->__levelNames);
        // If it exists
            // Simply use existing ID
            // else
        if(!$id){
            $id = null;
        }
        // TODO: Determine whether we want to simply output error if not in DB
        // return the ID
        return $id;
    }

    // set a level to language in the $languagesAndLevels array
    private function setLanguageLevel($languageName, $levelID, &$languagesAndLevels){
        $languageName = $this->greekStringConversion->grstrtoupper($languageName);
        // Check whether level exists in the DB
        $id = array_search($languageName, $this->__langNames);
        if($id !== false) {
            // if language is not existent in $languagesAndLevels array
            // ignore it
            if(array_key_exists($id, $languagesAndLevels)) {
                $languagesAndLevels[$id] = $levelID;
            }
        }
    }

    // returns language, languages_levels array for DB insert
    private function getLanguagesArrayForDBInsert($languages, $languages_levels, $id){
        // Load array of languages->languageIDs

        // Initialize result array
        $resultArray = array();
        $languagesAndLevels = array();
        // Split language text into language strings
        $languages = array_map('trim', explode(',', $languages));
        // For every language
        foreach($languages as $language) {
            $sLangID = $this->getLanguageID($language);
            // Set found ID to result array as UNKNOWN for specific benefiter
            if ($sLangID != null) {
                $languagesAndLevels[$sLangID] = null;
            }
        }
        // Extract language levels map from language_levels
        $languagesLevels = array_map('trim', explode(',', $languages_levels));
        // For every language level
        foreach($languagesLevels as $languageLevel) {
            // Update corresponding language with the given language level
            $tmp = array_map('trim', explode('(', $languageLevel)); // '0' => language_description, '1' => language_level_description
            $tmp[1] = str_replace(')', '', $tmp[1]);
            $sLevelID = $this->getLanguageLevelID($tmp[1]);
            $this->setLanguageLevel($tmp[0], $sLevelID, $languagesAndLevels);
        }

        // for every key-value pair in the map
        foreach ($languagesAndLevels as $key => $value) {
            // add record to result array
            array_push($resultArray, array('language_id' => $key, 'language_level_id' => $value, 'benefiter_id' => $id));
        }

        // return result array
        return $resultArray;
    }
}
