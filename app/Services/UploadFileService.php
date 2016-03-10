<?php namespace App\Services;

use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\File_import_schema;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals;
use App\Models\Benefiters_Tables_Models\BenefiterReferrals_lookup;
use App\Services\ConversionsForFileUpload;
use App\Services\DatesHelper;
use App\Services\GreekStringConversionHelper;

class UploadFileService{

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
                // do nothing
            }
        }
        $this->selectAppropriateDBTableForEachFileRowColumns();

    }

    // selects the appropriate DB table for each column of a row
    public function selectAppropriateDBTableForEachFileRowColumns(){
        $allFileRows = File_import_schema::get();
        if($allFileRows != null) {
            foreach ($allFileRows as $singleRow) {
                try {
                    // TODO for each row log if the current row is added to DB. If no then print the benefiter's name & folder number that failed to be added to DB
                    $imported_benefiter_id = \DB::table('benefiters')->insertGetId($this->selectBenefitersColumnsAndValuesFromFileRow($singleRow));
                    $this->importReferrals($singleRow, $imported_benefiter_id);
                } catch(\Exception $e) {
                    echo 'Exception found';
                }
                // TODO (not for now) Add table to view to display the files that uploaded successfully. Only names and dates, to help while uploading.
//                $benefiterReferralsColumns = $this->selectBenefitersReferralsColumnsAndValuesFromFileRow($singleRow);
            }
        }
        // delete all content form the imported data after populating all relative tables
//        File_import_schema::truncate();
    }

    // selects and returns all the columns - values inserted from file that correspond to the benefiters DB table
    public function selectBenefitersColumnsAndValuesFromFileRow($singleRow){
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
}
