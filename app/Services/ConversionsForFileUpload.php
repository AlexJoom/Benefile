<?php namespace App\Services;

class ConversionsForFileUpload{

    private $greekStringConversion = null;

    public function __construct(){
        $this->greekStringConversion = new GreekStringConversionHelper();
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
        $genders = \DB::table('genders_lookup')->get();
        // change the gender name to gender id
        foreach($genders as $gender){
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
        $allCountryAbandonReasons = \DB::table('country_abandon_reasons_lookup')->get();
        // change the country abandon reason name to country abandon reason id
        foreach($allCountryAbandonReasons as $reason){
            $reason->description = $this->greekStringConversion->grstrtoupper($reason->description);
            if(strcasecmp($countryAbandonReasonFromFile, $reason->description) == 0){
                return $reason->id;
            }
        }
        // reason not found
        return null;
    }

    // match country of origin
    public function getOriginCountry($originCountryFromFile) {
        $countryFromFileUpper = $this->greekStringConversion->grstrtoupper($originCountryFromFile);
        $countryList = \DB::table('countries_lookup')->get();
        // Find if country is listed in table. If not, output error
        foreach ($countryList as $country){
            $countryRes = \Lang::get('country_list.' . $country->country_name);
            $countryResUpper = $this->greekStringConversion->grstrtoupper($countryRes);
            if (strcasecmp($countryFromFileUpper, $countryResUpper) == 0) {
                return $countryFromFileUpper;
            }
            // TODO: } else { return $error }
        }
    }


    // match nationality country
    public function getNationalityCountry($natCountryFromFile) {
        $countryFromFileUpper = $this->greekStringConversion->grstrtoupper($natCountryFromFile);
        // TODO: Do not call twice to populate country list.
        $countryList = \DB::table('countries_lookup')->get();
        // Find if country is listed in table. If not, output error
        foreach ($countryList as $country){
            $countryRes = \Lang::get('country_list.' . $country->country_name);
            $countryResUpper = $this->greekStringConversion->grstrtoupper($countryRes);
            if (strcasecmp($countryFromFileUpper, $countryResUpper) == 0) {
                return $countryFromFileUpper;
            }
            // TODO: } else { return $error }
        }
    }
    // get id from marital status name
    public function getMaritalStatusId($maritalStatusFromFile){
        $maritalStatusFromFile = $this->greekStringConversion->grstrtoupper($maritalStatusFromFile);
        $marital_statuses = \DB::table('marital_status_lookup')->get();
        // change the marital status name to the marital status id
        foreach($marital_statuses as $marital_status){
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
        $educations = \DB::table('education_lookup')->get();
        // change the education name to the education name id
        foreach($educations as $education){
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
        $binaryYesNo = \DB::table('binary_lookup')->get();
        foreach($binaryYesNo as $binary){
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
        $workTitles = \DB::table('work_title_list_lookup')->get();
        // change from work title name to work title id
        foreach($workTitles as $workTitle){
            $workTitle->work_title = $this->greekStringConversion->grstrtoupper($workTitle->work_title);
            if(strcasecmp($workTitleFromFile, $workTitle->work_title) == 0){
                return $workTitle->id;
            }
        }
        // no work title found
        return null;
    }
}
