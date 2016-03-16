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


    // returns data needed to display the benefiters work titles report
    public function getReportDataForBenefitersWorkTitle(){
        try {
            $usersCountByWork = \DB::select(\DB::raw("select work_title_id, count(work_title_id) as counter from benefiters group by work_title_id"));
            $workTitles = \DB::table('work_title_list_lookup')->get();
        } catch(\Exception $e){
            Log::error("A problem occurred while trying to count the users based on their work title.\n" . $e);
            return null;
        }
        // get array of the form 'work_title' => 'counter'
        $result = $this->getBenefitersWorkTitleNameCountArray($usersCountByWork, $workTitles);
        Log::info("Returning results with users based on their work title.");
        // return the newly created array
        return $result;
    }

    // returns an array of the form 'work_title' => 'counter' using
    // the users count by work and the work titles in the DB
    private function getBenefitersWorkTitleNameCountArray($usersCountByWork, $workTitles){
        // if there are no users working
        if($usersCountByWork == null or $workTitles == null){
            Log::error("Problem with getBenefitersWorkTitleNameCountArray function input. Returning null.");
            return null;
        } else {
            $tmp = array();
            foreach ($usersCountByWork as $usersCount) {
                foreach ($workTitles as $workTitle) {
                    if ($workTitle->id == $usersCount->work_title_id) {
                        $tmp[$workTitle->work_title] = $usersCount->counter;
                        break;
                    }
                }
            }
            Log::info("Array of the form 'work_title' => 'counter' created and will be returned right now.");
            return $tmp;
        }
    }
}

