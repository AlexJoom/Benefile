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
}
