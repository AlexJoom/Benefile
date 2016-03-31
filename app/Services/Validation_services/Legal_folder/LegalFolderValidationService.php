<?php
/**
 * Created by PhpStorm.
 * User: cdimitzas
 * Date: 31/3/2016
 * Time: 6:33 μμ
 */

namespace App\Services\Validation_services\Legal_folder;

use Validator;


class LegalFolderValidationService {
    // validation for legal folder form
    public function legalFolderValidatorService($request){
        return Validator::make($request,
            array(
                'asylum_request_date' => 'date|required',
                'request_progress' => 'max:2000',
                'penalty_text' => 'max:2000',
            )
        );
    }
} 