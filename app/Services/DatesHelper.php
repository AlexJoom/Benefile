<?php namespace app\Services;

use Carbon\Carbon;

class DatesHelper
{

    // get valid date for DB use from date String
    public function makeDBFriendlyDate($date)
    {
        if ($date != null) {
            $date = str_replace('/', '-', $date);
            $day = strtok($date, "-");
            $month = strtok("-");
            $year = strtok("-");
            if (is_numeric($day) and is_numeric($month) and is_numeric($year)) {
                if (strlen($day) <= 2 and strlen($month) <= 2 and strlen($year) <= 4) {
                    return Carbon::createFromDate($year, $month, $day);
                }
            }
        }
        return "";
    }

    // get date String appropriate for DB search
    public function makeDBSearchFriendlyDate($date)
    {
        if ($date != "") {
            return strtok($date, " ");
        } else {
            return $date;
        }
    }

    // gets Carbon Formatted String from simple Date String
    public function getDateStringFromSimpleString($date){
        $date = $this->makeDBFriendlyDate($date);
        return ($date != "") ? $date->toDateTimeString() : "";
    }

    // gets finely formatted String from DB Date
    public function getFinelyFormattedStringDateFromDBDate($date){
        if($date == "0000-00-00" || $date == "0000-00-00 00:00:00"){
            $date = "";
            return $date;
        } else {
            if($date != "") {
                if (strlen($date) > 10) {
                    $data = substr($date, 0, -9);
                } else {
                    $data = $date;
                }
                $tmp = explode('-', $data);
                $data = $tmp[2] . '-' . $tmp[1] . '-' . $tmp[0];
                return $data;
            }
        }
    }

    // gets the difference between two dates in days
    public function getDifferenceInDays($date1, $date2){
        return $this->makeDBFriendlyDate($date1)->diffInDays($this->makeDBFriendlyDate($date2));
    }

    // gets current time string
    public function getCurrentTimeString(){
        return Carbon::now()->toDateTimeString();
    }
}
