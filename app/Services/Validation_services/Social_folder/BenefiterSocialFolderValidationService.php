<?php
/**
 * Created by PhpStorm.
 * User: cdimitzas
 * Date: 31/3/2016
 * Time: 6:43 μμ
 */

namespace App\Services\Validation_services\Social_folder;

use Validator;

class BenefiterSocialFolderValidationService {
    // validates the social folder view form input
    public function socialFolderValidationService($request){
        return Validator::make($request, array(
            'comments' => 'max:2000|required',
        ));
    }

    // validates the social folder view form input
    public function sessionValidationService($request){
        return Validator::make($request, array(
            'session_date' => 'date|required',
            'session_comments' => 'max:2000',
        ));
    }
} 