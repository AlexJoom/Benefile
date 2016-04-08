<?php namespace App\Services;

use App\Models\Benefiters_Tables_Models\Origin_country_lookup;

class ConversionsForFileUpload{

    private $greekStringConversion = null;
    private $genders = null;
    private $allCountryAbandonReasons = null;
    private $countryList = null;
    private $marital_statuses = null;
    private $educations = null;
    private $binaryYesNo = null;
    private $workTitles = null;

    public function __construct(){
        $this->greekStringConversion = new GreekStringConversionHelper();
        $this->genders = \DB::table('genders_lookup')->get();
        $this->allCountryAbandonReasons = \DB::table('country_abandon_reasons_lookup')->get();
        $this->countryList = \DB::table('countries_lookup')->get();
        $this->marital_statuses = \DB::table('marital_status_lookup')->get();
        $this->educations = \DB::table('education_lookup')->get();
        $this->binaryYesNo = \DB::table('binary_lookup')->get();
        $this->workTitles = \DB::table('work_title_list_lookup')->get();
        return($this->genders);
    }

    // get id from gender name
    public function getGenderId($genderFromFile){
        $genderFromFile = $this->greekStringConversion->grstrtoupper($genderFromFile);
        // check if a monogram is stored in csv instead of full gender name
        if($genderFromFile == \Lang::get('gender_monograms.w') or $genderFromFile == \Lang::get('gender_monograms.f')){
            $genderFromFile = $this->greekStringConversion->grstrtoupper(\Lang::get('basic_info_form.female'));
        } else if($genderFromFile == \Lang::get('gender_monograms.m')){
            $genderFromFile = $this->greekStringConversion->grstrtoupper(\Lang::get('basic_info_form.male'));
        }
        // change the gender name to gender id
        foreach($this->genders as $gender){
            $gender->gender = $this->greekStringConversion->grstrtoupper($gender->gender);
            if(strcasecmp($genderFromFile, $gender->gender) == 0){
                return $gender->id;
            }
        }
        // gender not found
        return null;
    }

    // get id from country abandon reason name
    public function getCountryAbandonReasonId($countryAbandonReasonFromFile){
        $countryAbandonReasonFromFile = $this->greekStringConversion->grstrtoupper($countryAbandonReasonFromFile);
        // change the country abandon reason name to country abandon reason id
        foreach($this->allCountryAbandonReasons as $reason){
            $reason->description = $this->greekStringConversion->grstrtoupper($reason->description);
            if(strcasecmp($countryAbandonReasonFromFile, $reason->description) == 0){
                return $reason->id;
            }
        }
        // reason not found
        return null;
    }

    // get country name and insert new country names to DB
    public function getCountry($countryFromFile) {
        $countryFromFileUpper = trim($this->greekStringConversion->grstrtoupper($countryFromFile));
        // Find if country is listed in table. If not, output error
        foreach ($this->countryList as $country){
            $countryRes = $country->name;
            $countryResUpper = $this->greekStringConversion->grstrtoupper($countryRes);
            if (strcasecmp($countryFromFileUpper, $countryResUpper) == 0) {
                return $countryFromFileUpper;
            }
            // TODO: } else { return $error }
        }
        // country is not found, so insert to DB and then return it
        $newCountry = new Origin_country_lookup();
        $newCountry->name = $countryFromFileUpper;
        $newCountry->save();
        array_push($this->countryList, $newCountry);
        return $countryFromFileUpper;
    }

    // get id from marital status name
    public function getMaritalStatusId($maritalStatusFromFile){
        $maritalStatusFromFile = $this->greekStringConversion->grstrtoupper($maritalStatusFromFile);
        // change the marital status name to the marital status id
        foreach($this->marital_statuses as $marital_status){
            $marital_status->marital_status_title = $this->greekStringConversion->grstrtoupper($marital_status->marital_status_title);
            if(strcasecmp($maritalStatusFromFile, $marital_status->marital_status_title) == 0){
                return $marital_status->id;
            }
        }
        // marital status not found
        return null;
    }

    // get id from education name
    public function getEducationId($educationFromFile){
        $educationFromFile = $this->greekStringConversion->grstrtoupper($educationFromFile);
        // change the education name to the education name id
        foreach($this->educations as $education){
            $education->education_title = $this->greekStringConversion->grstrtoupper($education->education_title);
            if(strcasecmp($educationFromFile, $education->education_title) == 0){
                return $education->id;
            }
        }
        // education not found
        return null;
    }

    // get id for yes or no answer
    public function getYesOrNoId($answer){
        $greekStringConversion = new GreekStringConversionHelper();
        $answer = $greekStringConversion->grstrtoupper($answer);
        foreach($this->binaryYesNo as $binary){
            $binary->description = $greekStringConversion->grstrtoupper($binary->description);
            if(strcasecmp($answer, $binary->description) == 0){
                return $binary->id;
            }
        }
        // no yes or no found in answer
        return null;
    }

    /** NOT NEEDED WITH THE NEW .CSV FILE */
    // get legal work id
//    public function getLegalWorkId($legalWorkFromFile){
//        $legalWorkFromFile = $this->greekStringConversion->grstrtoupper($legalWorkFromFile);
//        $legallyWorking = \DB::table('working_legally_lookup')->get();
//        // change from legal work name, to legal work id
//        foreach($legallyWorking as $legalWork){
//            $legalWork->description = $this->greekStringConversion->grstrtoupper($legalWork->description);
//            if(strcasecmp($legalWorkFromFile, $legalWork->description) == 0){
//                return $legalWork->id;
//            }
//        }
//        // no legal work found
//        return null;
//    }

    // get work title id
    public function getWorkTitleId($workTitleFromFile){
        $workTitleFromFile = $this->greekStringConversion->grstrtoupper($workTitleFromFile);
        // change from work title name to work title id
        foreach($this->workTitles as $workTitle){
            $workTitle->work_title = $this->greekStringConversion->grstrtoupper($workTitle->work_title);
            if(strcasecmp($workTitleFromFile, $workTitle->work_title) == 0){
                return $workTitle->id;
            }
        }
        // no work title found
        return null;
    }
}
