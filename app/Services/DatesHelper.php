<?php namespace app\Services;

use Carbon\Carbon;

class DatesHelper
{

    // get valid date for DB use from date String
    public function makeDBFriendlyDate($date)
    {
        if ($date != null) {
            $day = strtok($date, "-");
            $month = strtok("-");
            $year = strtok("-");
            return Carbon::createFromDate($year, $month, $day);
        } else {
            return "";
        }
    }
}
