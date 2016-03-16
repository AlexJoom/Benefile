<?php namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class ReportsService{

    // returns data needed to display the users roles report
    public function getReportDataForUsersRoles(){
        try {
            $doctorsCount = \DB::select(\DB::raw("select count(*) as counter from users where user_role_id = 2"));
            $legalsCount = \DB::select(\DB::raw("select count(*) as counter from users where user_role_id = 3"));
            $socialsCount = \DB::select(\DB::raw("select count(*) as counter from users where user_role_id = 4"));
            $psychologistsCount = \DB::select(\DB::raw("select count(*) as counter from users where user_role_id = 5"));
        } catch(\Exception $e){
            Log::error("A problem occurred while trying to count the users based on users roles.");
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

}

