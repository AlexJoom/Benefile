<?php namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\EducationLookup;
use App\Models\Benefiters_Tables_Models\medical_visits;

class ReportsService{

    // returns data needed to display the users roles report
    public function getReportDataForUsersRoles(){
        try {
            $doctorsCount = \DB::select(\DB::raw("select count(*) as counter from users where user_role_id = 2"));
            $legalsCount = \DB::select(\DB::raw("select count(*) as counter from users where user_role_id = 3"));
            $socialsCount = \DB::select(\DB::raw("select count(*) as counter from users where user_role_id = 4"));
            $psychologistsCount = \DB::select(\DB::raw("select count(*) as counter from users where user_role_id = 5"));
        } catch(\Exception $e){
            Log::error("A problem occurred while trying to count the users based on users roles.\n" . $e);
            return null;
        }
        Log::info("Returning result with users based on their roles.");
        // everything went ok, return results
        return array(
            'doctors' => $doctorsCount[0]->counter,
            'legals' => $legalsCount[0]->counter,
            'socials' => $socialsCount[0]->counter,
            'psychologists' => $psychologistsCount[0]->counter,
        );
    }

    public function getReportDataForUsersMaritalStatus() {
        try {
            // $maritalStatuses = \DB::select(\DB::raw("select id, marital_status_title from marital_status_lookup group by id"));
            $benefitersMaritalStatuses = \DB::select(\DB::raw("select marital_status_lookup.id, marital_status_lookup.marital_status_title, count(benefiters.marital_status_id) as marital_counter from marital_status_lookup left join benefiters on (marital_status_lookup.id = benefiters.marital_status_id) group by marital_status_lookup.id"));
        } catch (\Exception $e) {
            Log::error("A problem occured while trying to count the users based on marital status.");
            return null;
        }
        Log::info("Returning result with users based on their marital status.");
        // dd($benefitersMaritalStatuses);
        return $benefitersMaritalStatuses;
    }

    public function getReportDataForBenefitersAge() {
        try {
            // $benefitersAge = \DB::select(\DB::raw("select datediff(current_date, str_to_date(t.birth_date, '%Y-%m-%d'))/365 as ageInYears from benefiters t"));
            $benefitersAge = \DB::select(\DB::raw(" select count(*) as counter, floor(datediff(current_date, str_to_date(t.birth_date, '%Y-%m-%d'))/365/10)*10 as ageInYears from benefiters t group by ageInYears"));
            // dd($benefitersAge);
        } catch (\Exception $e) {
            return null;
        }

        return $benefitersAge;
    }

    public function getReportDataForBenefitersLegalStatus() {
        try {
            $benefitersLegalStatuses = \DB::select(\DB::raw("select legal_status_lookup.id, legal_status_lookup.description, count(benefiters_legal_status.id) as legal_counter from legal_status_lookup left join benefiters_legal_status on (legal_status_lookup.id = benefiters_legal_status.legal_lookup_id) group by legal_status_lookup.id"));
        } catch (\Exception $e) {
            Log::error("A problem occured while trying to count the benefiters based on their legal status.\n" . $e);
            return null;
        }

        return $benefitersLegalStatuses;
    }


    // returns data needed to display the benefiters work titles report
    public function getReportDataForBenefitersWorkTitle(){
        try {
            $benefitersCountByWork = \DB::select(\DB::raw("select work_title_id, count(work_title_id) as counter from benefiters group by work_title_id"));
            $workTitles = \DB::table('work_title_list_lookup')->get();
        } catch(\Exception $e){
            Log::error("A problem occurred while trying to count the users based on their work title.\n" . $e);
            return null;
        }
        // get array of the form 'work_title' => 'counter'
        $result = $this->getBenefitersWorkTitleNameCountArray($benefitersCountByWork, $workTitles);
        Log::info("Returning results with users based on their work title.");
        // return the newly created array
        return $result;
    }

    // returns data needed to display the medical visits location report
    public function getReportDataForMedicalVisitsLocation(){
        try{
            $medicalVisitsByLocation = \DB::select(\DB::raw("select mll.description as location, count(mv.medical_location_id) as counter from medical_location_lookup as mll left join medical_visits as mv on mv.medical_location_id = mll.id group by mll.id"));
        } catch(\Exception $e) {
            Log::error("A problem occurred while trying to count the medical visits based on their location.\n" . $e);
            return null;
        }
        // return the results to the controller
        Log::info("Returning results with medical visits based on their location.");
        return $medicalVisitsByLocation;
    }

    // returns data needed to display the number of benefiters per medical visits number report
    public function getReportDataForBenefitersPerMedicalVisitsCount(){
        try{
            $benefitersPerMedicalVisits = \DB::select(\DB::raw("select visits_counter, count(*) as benefiters_counter from ( select benefiter_id, count(*) as visits_counter from medical_visits group by benefiter_id) as count_visits_table group by visits_counter order by visits_counter asc"));
        } catch(\Exception $e){
            Log::error("A problem occurred while trying to count the number of benefiters per medical visits number.\n" . $e);
            return null;
        }
        //
        Log::info("Returning results with number of benefiters per medical visits number.");
        return $benefitersPerMedicalVisits;
    }

    // returns how many benefiters joined by month
    public function getReportDataForRegisteredBenefiters() {
        try {
            // get benefiter registration number for any particular month.
            $benefitersCount = \DB::select(\DB::raw("select date_format(created_at, '%Y-%m') as created_at, count(id) as idcounter from benefiters group by date_format(created_at, '%Y %m')"));
            // $benefitersCount = \DB::select(\DB::raw("select created_at, count(id) as idcounter from benefiters group by year(created_at), month(created_at)"));
        } catch (\Exception $e) {
            Log::error("A problem occured while trying to count the users based on registration date.\n" . $e);
            return null;
        }

        Log::info("Returning result with users based on their registration date.");
        return $benefitersCount;
    }

    // returns all the marital statuses stored in DB
    public function getAllMaritalStatuses(){
        return \DB::table('marital_status_lookup')->get();
    }

    // returns all the legal statuses stored in DB
    public function getAllLegalStatuses(){
        return \DB::table('legal_status_lookup')->get();
    }

    // returns all the education titles stored in DB
    public function getAllEducationTitles(){
        return \DB::table('education_lookup')->get();
    }

    // returns all the work titles stored in DB
    public function getAllWorkTitles(){
        return \DB::table('work_title_list_lookup')->get();
    }

    // returns all the medical incident types stored in DB
    public function getAllMedicalIncidentTypes(){
        return \DB::table('medical_incident_type_lookup')->get();
    }

    // returns all the medical locations stored in DB
    public function getAllMedicalLocations(){
        return \DB::table('medical_location_lookup')->get();
    }

    // returns all the medical examination results stored in DB
    public function getAllMedicalExaminationResults(){
        return \DB::table('medical_examination_results_lookup')->get();
    }

    // perform search
    public function getSearchResults($request){
        $datesHelper = new DatesHelper();
        $queryString = "select b.folder_number, b.name, b.lastname, b.telephone, floor(datediff(current_date, str_to_date(b.birth_date, '%Y-%m-%d'))/365) as age_in_years, count(mv.id) as incidents_counter, date(b.created_at) as created_at from benefiters as b left join medical_visits as mv on b.id = mv.benefiter_id left join medical_examination_results as mer on mv.id = mer.medical_visit_id left join medical_medication as mm on mv.id = mm.medical_visit_id";
        $queryString2 = " group by b.id";
//        $queryStringTest = "select * from (select b.folder_number, b.name, b.lastname, b.telephone, count(mv.id) as incidents_counter from benefiters as b left join medical_visits as mv on b.id = mv.benefiter_id left join medical_examination_results as mer on mv.id = mer.medical_visit_id left join medical_medication as mm on mv.id = mm.medical_visit_id group by b.id) as median_table";
        $firstWhereParameter = true;
        $firstWhereParameterExternalSelect = true;
        if($request['marital_status_id'] != 0) {
            $queryString = $queryString . " where ";
            $queryString = $queryString . 'b.marital_status_id=' . $request['marital_status_id'];
            $firstWhereParameter = false;
        }
        if($request['legal_status_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'bls.legal_lookup_id=' . $request['legal_status_id'];
            $firstWhereParameter = false;
        }
        if($request['education_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'b.education_id=' . $request['education_id'];
            $firstWhereParameter = false;
        }
        if(!empty($request['gender_id'])){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'b.gender_id=' . $request['gender_id'];
            $firstWhereParameter = false;
        }
        if($request['work_title_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'b.work_title_id=' . $request['work_title_id'];
            $firstWhereParameter = false;
        }
        if($request['drug'] != ""){
            $drugId = $this->getMedicationIdFromName($request['drug']);
            if($drugId != null) {
                if (!$firstWhereParameter) {
                    $queryString = $queryString . " and ";
                } else {
                    $queryString = $queryString . " where ";
                }
                $queryString = $queryString . 'mm.medication_lookup_id=' . $drugId;
                $firstWhereParameter = false;
            }
        }
        if($request['incident_type_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'mv.medical_incident_id=' . $request['incident_type_id'];
            $firstWhereParameter = false;
        }
        if($request['location_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'mv.medical_location_id=' . $request['location_id'];
            $firstWhereParameter = false;
        }
        if($request['doctor_name'] != ""){
            $doctorId = $this->getDoctorIdFromName($request['doctor_name']);
            if($doctorId != null) {
                if (!$firstWhereParameter) {
                    $queryString = $queryString . " and ";
                } else {
                    $queryString = $queryString . " where ";
                }
                $queryString = $queryString . 'mv.doctor_id=' . $doctorId;
                $firstWhereParameter = false;
            }
        }
        if($request['examination_results_id'] != 0){
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'mer.results_lookup_id=' . $request['examination_results_id'];
            $firstWhereParameter = false;
        }
        if($request['incident_from'] != "" and $request['incident_to'] != ""){
            // if difference in days between the two dates is negative, the incident_to date is earlier
            if($datesHelper->getDifferenceInDays($request['incident_from'], $request['incident_to']) < 0){
                $tmp = $request['incident_from'];
                $request['incident_from'] = $request['incident_to'];
                $request['incident_to'] = $tmp;
            }
            if(!$firstWhereParameter){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'mv.medical_visit_date between \'' . $datesHelper->makeDBSearchFriendlyDate($datesHelper->makeDBFriendlyDate($request['incident_from'])) . '\' and \'' . $datesHelper->makeDBSearchFriendlyDate($datesHelper->makeDBFriendlyDate($request['incident_to'])) . '\'';
            $firstWhereParameter = false;
        }
        $queryString = "select * from (" . $queryString . $queryString2 . ") as median_table";
        if($request['age'] != "" and is_numeric($request['age'])) {
            $queryString = $queryString . " where ";
            $queryString = $queryString . 'age_in_years=' . $request['age'];
            $firstWhereParameterExternalSelect = false;
        }
        if($request['incidents_number'] != ""){
            if(!$firstWhereParameterExternalSelect){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'incidents_counter=' . $request['incidents_number'];
            $firstWhereParameter = false;
        }
        if($request['insertion_date'] != ""){
            if(!$firstWhereParameterExternalSelect){
                $queryString = $queryString . " and ";
            } else {
                $queryString = $queryString . " where ";
            }
            $queryString = $queryString . 'created_at=\'' . $datesHelper->makeDBSearchFriendlyDate($datesHelper->makeDBFriendlyDate($request['insertion_date'])). '\'';
            $firstWhereParameterExternalSelect = false;
        }
        if(!$firstWhereParameter or !$firstWhereParameterExternalSelect) {
            return \DB::select(\DB::raw($queryString));
        } else {
            return null;
        }
    }

    // returns an array of the form 'work_title' => 'counter' using
    // the users count by work and the work titles in the DB
    private function getBenefitersWorkTitleNameCountArray($benefitersCountByWork, $workTitles){
        // if there are no users working
        if($benefitersCountByWork == null or $workTitles == null){
            Log::error("Problem with getBenefitersWorkTitleNameCountArray function input. Returning null.");
            return null;
        } else { // else create the requested array
            $tmp = array();
            foreach ($benefitersCountByWork as $benefitersCount) {
                foreach ($workTitles as $workTitle) {
                    // compare the work title id with the benefiters work title id
                    // to make the array as it been needed for the view's chart creation
                    if ($workTitle->id == $benefitersCount->work_title_id) {
                        $tmp[$workTitle->work_title] = $benefitersCount->counter;
                        break;
                    }
                }
            }
            // return the correctly formatted array
            Log::info("Array of the form 'work_title' => 'counter' created and will be returned right now.");
            return $tmp;
        }
    }

    // get medication id from name
    private function getMedicationIdFromName($drug){
        $tmp = \DB::table('medical_medication_lookup')->where('description', 'like', '%' . $drug . '%')->first();
        if($tmp != null) {
            Log::info("Returning the drug id.");
            return $tmp->id;
        } else {
            Log::error("Couldn't find the drug id.");
            return null;
        }
    }

    // get doctor id from name
    private function getDoctorIdFromName($doctorName){
        $tmp = \DB::table('users')->where('user_role_id', '=', 2)->where('lastname', 'like', '%' . $doctorName . '%')->orWhere('name', 'like', '%' . $doctorName . '%')->first();
        if($tmp != null) {
            Log::info("Returning the doctor's id.");
            return $tmp->id;
        } else {
            Log::error("Couldn't find the doctor's id");
            return null;
        }
    }

    // ------------------------------------------------------------------------------------------------ //
    // ----------------------- REPORT: Benefiters vs gender ------------------------------------------- //
    public function getReport_benefiters_vs_gender(){
        // count benefiters regarding each gender type
        // male
        $males_count = count(Benefiter::where('gender_id',1)->get());
        $females_count = count(Benefiter::where('gender_id',2)->get());
        $others_count = count(Benefiter::where('gender_id',3)->get());

        // percentages
        $total = $males_count + $females_count + $others_count;
        $male_percentage = round(($males_count/$total) * 100);
        $female_percentage = round(($females_count/$total) * 100);
        $other_percentage = round(($others_count/$total) * 100);

        $total_icons = $male_percentage + $female_percentage + $other_percentage;

        $result = array('male'=>$males_count, 'male_percentage'=>$male_percentage,
                        'female'=>$females_count,'female_percentage'=>$female_percentage,
                        'other'=>$others_count, 'other_percentage'=>$other_percentage,
                        'total_icons'=>$total_icons);
        // return array with gender_type => number
        return $result;
    }

    // -------------------------------------------------------------------------------------------------------- //
    // ----------------------- REPORT: Benefiters vs education ------------------------------------------------ //
    public function getReport_benefiters_vs_education(){
        // count benefiters regarding each education type
        $results = array();
        // get all lookup education levels
        $education_lookup = EducationLookup::get();
        // for each education level add to results array a pair of the total count of benefiters with this edu. level and the title of the education level.
        foreach($education_lookup as $edu_lookup){
            $count_benefiters_with_this_education_title = count(Benefiter::where('education_id',$edu_lookup['id'])->get());
            $education_level_result = ['benefiters_count_with_this_education_title'=> $count_benefiters_with_this_education_title,
                                'education_title'=>$edu_lookup['education_title']];
            array_push($results,$education_level_result);
        }
        return $results;
    }

    // -------------------------------------------------------------------------------------------------------- //
    // ----------------------- REPORT: Benefiters vs doctor specialty ----------------------------------------- //
    public function getReport_benefiters_vs_doctor(){
        // count benefiters regarding which doctor have visit
        $results = array();
        $CSS_COLOR_NAMES = ["AliceBlue","AntiqueWhite","Aqua","Aquamarine","Azure","Beige","Bisque","Black","BlanchedAlmond","Blue","BlueViolet",
                            "Brown","BurlyWood","CadetBlue","Chartreuse","Chocolate","Coral","CornflowerBlue","Cornsilk","Crimson","Cyan",
                            "DarkBlue","DarkCyan","DarkGoldenRod","DarkGray","DarkGrey","DarkGreen","DarkKhaki","DarkMagenta","DarkOliveGreen",
                            "Darkorange","DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen","DarkSlateBlue","DarkSlateGray","DarkSlateGrey",
                            "DarkTurquoise","DarkViolet","DeepPink","DeepSkyBlue","DimGray","DimGrey","DodgerBlue","FireBrick","FloralWhite",
                            "ForestGreen","Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod","Gray","Grey","Green","GreenYellow","HoneyDew",
                            "HotPink","IndianRed","Indigo","Ivory","Khaki","Lavender","LavenderBlush","LawnGreen","LemonChiffon","LightBlue",
                            "LightCoral","LightCyan","LightGoldenRodYellow","LightGray","LightGrey","LightGreen","LightPink","LightSalmon",
                            "LightSeaGreen","LightSkyBlue","LightSlateGray","LightSlateGrey","LightSteelBlue","LightYellow","Lime","LimeGreen",
                            "Linen","Magenta","Maroon","MediumAquaMarine","MediumBlue","MediumOrchid","MediumPurple","MediumSeaGreen",
                            "MediumSlateBlue","MediumSpringGreen","MediumTurquoise","MediumVioletRed","MidnightBlue","MintCream","MistyRose",
                            "Moccasin","NavajoWhite","Navy","OldLace","Olive","OliveDrab","Orange","OrangeRed","Orchid","PaleGoldenRod",
                            "PaleGreen","PaleTurquoise","PaleVioletRed","PapayaWhip","PeachPuff","Peru","Pink","Plum","PowderBlue","Purple",
                            "Red","RosyBrown","RoyalBlue","SaddleBrown","Salmon","SandyBrown","SeaGreen","SeaShell","Sienna","Silver",
                            "SkyBlue","SlateBlue","SlateGray","SlateGrey","Snow","SpringGreen","SteelBlue","Tan","Teal","Thistle","Tomato",
                            "Turquoise","Violet","Wheat","White","WhiteSmoke","Yellow","YellowGreen"];

        $color_array = ["#FF0F00", "#FF6600", "#FF9E01", "#FCD202", "#F8FF01", "#B0DE09", "#04D215", "#0D8ECF", "#0D52D1", "#2A0CD0", "#8A0CCF",
                        "#CD0D74", "#710935", "#80AF44", "#A33D27", "#477709", "#3399ff", "#ff9933", "#663300", "#996633", "#267326", "#7300e6",
                        "#ff80ff", "#666699", "#66ccff", "#993300", "#3399ff", "#999966", "#ff6600", "#008080", "#00e68a", "#cc33ff", "#333300"];
        $counter = 0;
        // get all doctors from user table
        $subscribed_doctors = User::with('subrole')->where('user_role_id', 2)->get();
        foreach($subscribed_doctors as $doctor){
            $count_benefiters_with_same_doctor = count(medical_visits::where('doctor_id', $doctor['id'])->get());
            $doctor_name = $doctor['name'] . " " . $doctor['lastname'];
            $doctor_specialty = $doctor['subrole']['subrole'];
            $doctor_type_result = [ 'doctor' =>  $doctor_name. '<br>' .'('. $doctor_specialty . ')',
                                    'count_benefiters_with_same_doctor' => $count_benefiters_with_same_doctor,
                                    'color' => $color_array[array_rand($color_array)]];
            array_push($results, $doctor_type_result);
            $counter++;
        }
        // return array with doctor => number of benefiters
        return $results;
    }

    // -------------------------------------------------------------------------------------------------------- //
    // ----------------------- REPORT: Benefiters vs medical condition category ------------------------------- //
    public function getReport_benefiters_vs_medical_condition(){
        // count benefiters regarding their medical condition

        // return array with medical condition => number of benefiters with this medical condition
    }

    // -------------------------------------------------------------------------------------------------------- //
    // ----------------------- REPORT: Benefiters vs medical visits per month --------------------------------- //
    public function getReport_medical_visits_vs_date(){
        // count medical visits regarding time period (from , to)

        // return array with time_period => number of medical visits
    }
}

