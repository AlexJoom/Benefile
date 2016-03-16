<?php namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\Benefiters_Tables_Models\Benefiter;

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
            $benefitersCount = \DB::select(\DB::raw("select created_at, count(id) as idcounter from benefiters group by date_format(created_at, '%Y%m')"));
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

    // ------------------------------------------------------------------------------------------------ //
    // ----------------------- REPORT: Benefiters vs education ---------------------------------------- //
    public function getReport_benefiters_vs_education(){
        // count benefiters regarding each education type

        // return array with education_type => number
        $results = array('illiterate' => 2, 'primary_school'=> 10, 'high_school'=>26,
                        'lyceum'=> 46, 'TEE'=>89, 'TEI'=>27, 'AEI'=>19,
                        'master'=>73, 'phd'=>53);
        return $results;
    }

    // ------------------------------------------------------------------------------------------------ //
    // ----------------------- REPORT: Benefiters vs education ---------------------------------------- //
    public function getReport_benefiters_vs_doctor(){
        // count benefiters regarding which doctor have visit

        // return array with doctor => number of benefiters
    }

    // ------------------------------------------------------------------------------------------------ //
    // ----------------------- REPORT: Benefiters vs education ---------------------------------------- //
    public function getReport_benefiters_vs_medical_condition(){
        // count benefiters regarding their medical condition

        // return array with medical condition => number of benefiters with this medical condition
    }

    // ------------------------------------------------------------------------------------------------ //
    // ----------------------- REPORT: Benefiters vs education ---------------------------------------- //
    public function getReport_medical_visits_vs_date(){
        // count medical visits regarding time period (from , to)

        // return array with time_period => number of medical visits
    }
}

