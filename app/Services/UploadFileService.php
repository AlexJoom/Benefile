<?php namespace App\Services;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\File_import_schema;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals_lookup;
use App\Models\Benefiters_Tables_Models\ImportCSV_BasicInfo;
use App\Services\ConversionsForFileUpload;
use App\Services\DatesHelper;
use \Carbon\Carbon;
use App\Services\GreekStringConversionHelper;

class UploadFileService{

    private $__langNames = array();
    private $__levelNames = array();
    private $__legalStatuses = array();
    private $__errors = array();
    private $socialService;

    public function __construct(){
        $this->greekStringConversion = new GreekStringConversionHelper();
        $this->socialService = new SocialFolderService();
    }

    // inserts all values to DB
    public function fileImport($filePath){
        header('Content-Type: text/html; charset=UTF-8');
        // Call benefiter table in db
        $file_import_Fields = ['id',
            'folder_number',
            'name',
            'lastname',
            'fathers_name',
            'mothers_name',
            'gender',                           // check for string type (full gender name or only a letter)
            'origin_country',
            'nationality_country',
            'birth_date',
            'arrival_date',
            'address',
            'telephone',
            'marital_status',
            'number_of_children',
            'relatives_residence',
            'legal_status',
            'legal_status_details',             // ??? not shown on excel
            'legal_status_exp_date',            // ??? not shown on excel
            'education',
            'language',
            'language_level',
            'other_language',                   // ??? not shown on excel
            'language_interpreter_needed',      // ??? not shown on excel
            'is_benefiter_working',
            'work_title',
            'working_legally',
            'country_abandon_reason',
            'travel_route',
            'travel_duration',
            'detention_duration',

            'has_social_reference',             // ??? not shown on excel
            'social_reference_actions',         // ??? not shown on excel
            'social_reference_date',            // ??? not shown on excel

            'has_medical_reference',            // ??? not shown on excel
            'medical_reference_actions',        // ??? not shown on excel
            'medical_reference_date',           // ??? not shown on excel

            'has_legal_reference',              // ??? not shown on excel
            'legal_reference_actions',          // ??? not shown on excel
            'legal_reference_date',             // ??? not shown on excel

            'has_educational_reference',        // ??? not shown on excel
            'educational_reference_actions',    // ??? not shown on excel
            'educational_reference_date',       // ??? not shown on excel

            'social_history'                    // ??? not shown on excel
        ];
        // get max id in File_import_schema so that it won't try to insert benefiters already inserted via file
        $maxIdInFileImportSchema = File_import_schema::max('id');
        if($maxIdInFileImportSchema == null){
            $maxIdInFileImportSchema = 0;
        }
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
                array_push($this->__errors, \Lang::get('upload_file_errors.import_csv_row_error1') . $file_import->folder_number . \Lang::get('upload_file_errors.import_csv_row_error2'));
            }
        }
        \DB::insert(\DB::raw('insert into work_title_list_lookup (work_title) select distinct f.work_title  from  File_Import_Schema f left outer join work_title_list_lookup work_title on f.work_title = work_title.work_title where work_title.id is null;'));
        $this->selectAppropriateDBTableForEachFileRowColumns($maxIdInFileImportSchema);
        return $this->__errors;
    }

    // ----------------------------------------------------------------- //
    // Insert upload main info (file name & date) to DB
    public function importedFilesTable($filename){
        $importedFile = new ImportCSV_BasicInfo();
        $importedFile->csv_name = $filename;
        $importedFile->save();
    }

    // fetch all CSV import history from DB
    public function findImportedHistory(){
        $importedHistory = ImportCSV_BasicInfo::get();
        return $importedHistory;
    }

    // selects the appropriate DB table for each column of a row
    private function selectAppropriateDBTableForEachFileRowColumns($maxIdInFileImportSchema){
        $allFileRows = File_import_schema::where('id', '>', $maxIdInFileImportSchema)->get();
        if($allFileRows != null) {
            foreach ($allFileRows as $singleRow) {
                try {
                    $imported_benefiter_id = \DB::table('benefiters')->insertGetId($this->selectBenefitersColumnsAndValuesFromFileRow($singleRow));
                    $this->socialService->saveSocialFolderToDB(array('comments' => ''), $imported_benefiter_id);
                    $this->insertLanguagesToDBFromFile($singleRow->language, $singleRow->language_level, $imported_benefiter_id);
                    $this->insertLegalStatusToDBFromFile($singleRow->legal_status, $singleRow->legal_status_details, $singleRow->legal_status_exp_date, $imported_benefiter_id);
                    $this->importReferrals($singleRow, $imported_benefiter_id);
                } catch(\Exception $e) {
                    array_push($this->__errors, \Lang::get('upload_file_errors.insert_benefiter_error') . $singleRow->folder_number);
                }
                // TODO (not for now) Add table to view to display the files that uploaded successfully. Only names and dates, to help while uploading.
//                $benefiterReferralsColumns = $this->selectBenefitersReferralsColumnsAndValuesFromFileRow($singleRow);
            }
        }
        // delete all content form the imported data after populating all relative tables
//        File_import_schema::truncate();
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
        $singleRow->country_abandon_reason = $conversionForFile->getCountryAbandonReasonId($singleRow->country_abandon_reason);
        $singleRow->work_title = $conversionForFile->getWorkTitleId($singleRow->work_title);
        $tmpdate = \Carbon\Carbon::now();
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
            'work_title_id' => $singleRow->work_title,
            'working_legally' => $singleRow->working_legally,
            'country_abandon_reason_id' => $singleRow->country_abandon_reason,
            'travel_route' => $singleRow->travel_route,
            'travel_duration' => $singleRow->travel_duration,
            'detention_date' => $datesHelper->makeDBFriendlyDate($singleRow->detention_duration),
            'social_history' => $singleRow->social_history,
            'document_manager_id' => \Auth::user()->id,
            'created_at' => $tmpdate,
        );
    }




    // ---------------------------------------------------------------------------------- //
    // for current imported benefiter add the respective referrals, from csv, to DB tables
    public function importReferrals($singleRow, $benefiter_id){
        // referrals lookup ids
        $social_referrence_lookup_id = BenefiterReferrals_lookup::where('description', 'LIKE', '%οινων%')->first()->id;
        $medical_referrence_lookup_id = BenefiterReferrals_lookup::where('description', 'LIKE', '%ατρικ%')->first()->id;
        $legal_referrence_lookup_id = BenefiterReferrals_lookup::where('description', 'LIKE', '%ομικ%')->first()->id;
        $educational_referrence_lookup_id = BenefiterReferrals_lookup::where('description', 'LIKE', '%δευση%')->first()->id;

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
    }

    // select the appropriate table columns for referrals and return them as an array
    public function selectOnlyReferrals($description, $referral_date, $benefiter_id, $referral_type_id){
        $datesHelper = new DatesHelper();
        $referralDb = array('description' => $description,
                            'referral_date' => $datesHelper->makeDBFriendlyDate($referral_date),
                            'user_id' => \Auth::user()->id,
                            'benefiter_id' => $benefiter_id,
                            'referral_lookup_id' => $referral_type_id);
        return $referralDb;
    }

    // inserts languages to DB
    private function insertLanguagesToDBFromFile($languages, $languages_levels, $id){
        $languagesAndLevels = $this->getLanguagesArrayForDBInsert($languages, $languages_levels, $id);
        if($languagesAndLevels != null) {
            foreach ($languagesAndLevels as $languageAndLevel) {
                \DB::table('benefiters_languages')->insert($languageAndLevel);
            }
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
            if($sLang != '') {
                array_push($this->__errors, \Lang::get('upload_file_errors.language_not_found_error') . $sLang);
            }
        }
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
            array_push($this->__errors, \Lang::get('upload_file_errors.level_not_found_error') . $sLevel);
        }
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
        // if $languagesAndLevels are not empty update the corresponding language level
        if($languagesAndLevels != "") {
            // For every language level
            foreach ($languagesLevels as $languageLevel) {
                // Update corresponding language with the given language level
                $tmp = array_map('trim', explode('(', $languageLevel)); // '0' => language_description, '1' => language_level_description
                if($tmp[0] != "") {
                    $tmp[1] = str_replace(')', '', $tmp[1]);
                    $sLevelID = $this->getLanguageLevelID($tmp[1]);
                    $this->setLanguageLevel($tmp[0], $sLevelID, $languagesAndLevels);
                }
            }
        }

        // for every key-value pair in the map
        foreach ($languagesAndLevels as $key => $value) {
            // add record to result array
            array_push($resultArray, array('language_id' => $key, 'language_level_id' => $value, 'benefiter_id' => $id));
        }

        // return result array
        return $resultArray;
    }

    // inserts legal statuses to DB
    private function insertLegalStatusToDBFromFile($legal_status, $legal_description, $legal_exp_date, $id){
        // get array for DB insert
        $legalStatus = $this->getLegalStatusArrayForDBInsert($legal_status, $legal_description, $legal_exp_date, $id);
        // if array has been returned successfully, insert it into DB
        if ($legalStatus != null){
            try {
                \DB::table('benefiters_legal_status')->insert($legalStatus);
            } catch(\Exception $e){
                array_push($this->__errors, \Lang::get('upload_file_errors.insert_legal_status_error') . $legal_status . \Lang::get('upload_file_errors.benefiter_with_id') . $id);
            }
        } else { // else display an error message
            array_push($this->__errors, \Lang::get('upload_file_errors.legal_status_not_found_error') . $legal_status);
        }
    }

    // returns the legal status id from legal status name
    private function findLegalStatusIdFromName($legal_status){
        // if $__legalStatuses is empty, then fill it with normalized legal statuses from DB...
        if(empty($this->__legalStatuses)){
            $allLegalStatuses = \DB::table('legal_status_lookup')->get();
            foreach($allLegalStatuses as $legalStatus){
                $this->__legalStatuses[$legalStatus->id] = $this->greekStringConversion->grstrtoupper($legalStatus->description);
            }
        }
        // ...else use the existent array
        // normalize $legal_status
        $tmp = $this->greekStringConversion->grstrtoupper($legal_status);
        $id = array_search($tmp, $this->__legalStatuses);
        // if legal status was not found in $legalStatuses array
        // return null
        if(!$id){
            $id = null;
        }
        return $id;
    }

    // returns an array suitable for legal status DB insert
    private function getLegalStatusArrayForDBInsert($legal_status, $legal_description, $legal_exp_date, $id){
        // get legal id using the legal name
        $legal_id = $this->findLegalStatusIdFromName($legal_status);
        // if legal id is found return an array suitable for DB insertion
        if($legal_id != null) {
            // get date for DB insert
            $datesHelper = new DatesHelper();
            $legal_exp_date = $datesHelper->makeDBFriendlyDate($legal_exp_date);
            return array(
                'legal_lookup_id' => $legal_id,
                'description' => $legal_description,
                'exp_date' => $legal_exp_date,
                'benefiter_id' => $id,
            );
        } else { // return null if legal status was not found
            return null;
        }
    }
}
