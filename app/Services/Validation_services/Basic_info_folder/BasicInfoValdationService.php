<?php
/**
 * Created by PhpStorm.
 * User: cdimitzas
 * Date: 31/3/2016
 * Time: 6:14 μμ
 */

namespace App\Services\Validation_services\Basic_info_folder;

use App\Services\DatesHelper;
use Validator;


class BasicInfoValdationService {

    private $datesHelper;

    public function __construct(){
        // initialize dates helper
        $this->datesHelper = new DatesHelper();
    }

    public function basicInfoValidationService($request, $id){
        $rules = array(
            'folder_number' => 'max:255|required|unique:benefiters,folder_number,'.$id,
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'fathers_name' => 'max:255',
            'mothers_name' => 'max:255',
            'nationality_country' => 'max:255',
            'origin_country' => 'max:255',
            'ethnic_group' => 'max:255',
            'birth_date' => 'date',
            'arrival_date' => 'date',
            'address' => 'max:255',
            'telephone' => 'min:5|max:20',
            'number_of_children' => 'integer',
            'chidren_names' => 'max:2000',
            'relatives_residence' => 'max:255',
            'education_specialization' => 'max:255',
            'working_title' => 'max:255',
            'travel_route' => 'max:255',
            'travel_duration' => 'max:255',
            'detention_date' => 'date',
            'social_history' => 'max:2000',
        );
        $legal_status_texts = $request['legal_status_text'];
        foreach($legal_status_texts as $i => $legal_status_text){
            $rules["legal_status_text." . $i] = 'max:255';
        }
        $legal_status_exp_dates = $request['legal_status_exp_date'];
        foreach($legal_status_exp_dates as $i => $legal_status_exp_date){
            $rules["legal_status_exp_date." . $i] = 'date';
            $legal_status_exp_dates[$i] = $this->datesHelper->makeDBFriendlyDate($legal_status_exp_date);
        }
        $request['birth_date'] = $this->datesHelper->makeDBFriendlyDate($request['birth_date']);
        $request['arrival_date'] = $this->datesHelper->makeDBFriendlyDate($request['arrival_date']);
        $request['detention_date'] = $this->datesHelper->makeDBFriendlyDate($request['detention_date']);
        return Validator::make($request, $rules);
    }
} 