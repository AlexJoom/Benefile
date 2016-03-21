<?php namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Benefiters_Tables_Models\Benefiter;
use App\Models\Benefiters_Tables_Models\EducationLookup;
use App\Models\Benefiters_Tables_Models\medical_visits;
use App\Models\Benefiters_Tables_Models\medical_examination_results_lookup;
use App\Models\Benefiters_Tables_Models\medical_examination_results;
use App\Models\PsychosocialSession;
use App\Models\Psychosocial_support_lookup;

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
        // get all doctors from user table
        $subscribed_doctors = User::with('subrole')->where('user_role_id', 2)->orWhere('user_role_id', 1)->get();
        foreach($subscribed_doctors as $doctor){
            $count_benefiters_with_same_doctor = count(medical_visits::where('doctor_id', $doctor['id'])->get());
            if($count_benefiters_with_same_doctor != 0){
                $doctor_name = $doctor['name'] . " " . $doctor['lastname'];

                if($doctor['user_role_id'] == 1){
                    $doctor_specialty = 'Διαχειριστής ';
                }else{
                    $doctor_specialty = $doctor['subrole']['subrole'];
                }

                $doctor_type_result = [ 'doctor' =>  $doctor_name. '<br>' .'('. $doctor_specialty . ')',
                    'count_benefiters_with_same_doctor' => $count_benefiters_with_same_doctor,
                    'color' => $color_array[array_rand($color_array)]];
                array_push($results, $doctor_type_result);
            }
        }
        // return array with doctor => number of benefiters
        return $results;
    }

    // -------------------------------------------------------------------------------------------------------- //
    // ----------------------- REPORT: Benefiters vs medical clinical condition category ---------------------- //
    public function getReport_benefiters_vs_clinical_conditions(){
        $results = array();
        // get all clinical conditions from lookup
        $clinical_conditions_lookup = medical_examination_results_lookup::get();

        // count benefiters regarding their medical condition
        foreach($clinical_conditions_lookup as $condition){
            // first we will make a benefiters id list with the current clinical condition.
            $medical_examination_results_with_same_clinical_condition = medical_examination_results::where('results_lookup_id',$condition['id'])->get();
            // then make an array with all benefiter_id with the current clinical condition.
            $benefiters_with_same_clinical_condition =array();
            foreach($medical_examination_results_with_same_clinical_condition as $med_exam_same_clinical){
                array_push($benefiters_with_same_clinical_condition, medical_visits::find($med_exam_same_clinical['medical_visit_id'])['benefiter_id']);
            }
            // then find the duplicities in the above array and count the result.
            $current_clinical_condition_counter = count(array_count_values($benefiters_with_same_clinical_condition));
            // pass all necessary for amchart.js results to another array.
            $clinical_conditions_result = [ 'clinical_condition_name' => $condition['description'],
                                            'clinical_condition_count' => $current_clinical_condition_counter];
            array_push($results, $clinical_conditions_result);
        }
        // return array with medical condition => number of benefiters with this medical condition
        return $results;
    }

    // -------------------------------------------------------------------------------------------------------- //
    // ----------------------- REPORT: Benefiters vs medical visits per month --------------------------------- //
    public function getReport_medical_visits_vs_date(){
        // in order to count the visits per month the only thing we have to do is to fetch all available medical visits
        // and count the medical visit dates with the same month.

        $results = array();
        $months = array();
        // get all medical visits
        $medical_visits = medical_visits::get();
        // for each visit remove the day part of the string (last three characters) and create a new array.
        foreach ($medical_visits as $visit) {
            $time = strtotime($visit['medical_visit_date']);
            $current_month = date('Y-m',$time);
            array_push($months, $current_month);
        }
        // for the new date array count for duplicities and create the necessary data pair.
        $array_duplicities = array_count_values($months);
        foreach($array_duplicities as $key => $per_month_count){
            $medical_result = ['per_month_date' => $key , 'visits_per_month' => $per_month_count ];
            array_push($results, $medical_result);
        }
        // Order results by date (ascending)
        foreach ($results as $key => $part) {
            $sort[$key] = strtotime($part['per_month_date']);
        }
        array_multisort($sort, SORT_ASC, $results);

        // return array with time_period => number of medical visits
        return $results;
    }

    // -------------------------------------------------------------------------------------------------------- //
    // ----------------------- REPORT: Benefiters vs phycological support ------------------------------------- //
    public function getReport_benefiters_vs_phycological_support(){
        $results = array();

        // get all phycological support types from lookup
        $phycological_support_types_lookup = Psychosocial_support_lookup::get();
        // get all phycological visits
        $phycological_visits = PsychosocialSession::select('social_folder_id', 'psychosocial_theme_id')->get();

        // foreach phycological support type count the benefiters avoiding duplicities
        foreach($phycological_support_types_lookup as $phycological_type){
            // benefiters with same psychosocial support type
            $benefiters_same_psychosocial_support_type = array();
            // here for each visit/session we create an array with all social folder ids registered for the current phycological support type
            foreach($phycological_visits as $visit){
                if($phycological_type['id'] == $visit['psychosocial_theme_id']){
                    array_push($benefiters_same_psychosocial_support_type, $visit['social_folder_id']);
                }
            }
            // then we count the duplicate result array
            $benefiters_count = count(array_count_values($benefiters_same_psychosocial_support_type));
            // we create the necessary pair of data, needed for the chart
            $phycological_support_result = ['$phycological_support_type'=> $phycological_type['description'], 'type_count'=> $benefiters_count];
            array_push($results, $phycological_support_result);
        }
        // return array with number of benefiters per phycological support type
        return $results;
    }
    
    // -------------------------------------------------------------------------------------------------------- //
    // ----------------------- REPORT: Benefiters registration numbers per month ------------------------------ //
    public function getRegistrationsVSMonthDate() {
        $results = array();
        $months = array();
        // get all benefiters
        $benefiters = Benefiter::get();
        foreach ($benefiters as $benefiter) {
            $time = strtotime($benefiter['created_at']);
            $current_month = date('Y-m', $time);
            array_push($months, $current_month);
        }

        // for the new date array count for duplicities and create the necessary data pair.
        $array_duplicities = array_count_values($months);
        foreach($array_duplicities as $key => $per_month_count){
            $registration_date = ['per_month_date' => $key , 'registrations_per_month' => $per_month_count ];
            array_push($results, $registration_date);
        }

        foreach ($results as $key => $part) {
            $sort[$key] = strtotime($part['per_month_date']);
        }
        array_multisort($sort, SORT_ASC, $results);
        return $results;
    }

}

