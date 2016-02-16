<?php namespace app\Services;

use Validator;
use Carbon\Carbon;

class SocialFolderService{

    // validate the social folder view form input
    public function socialFolderValidation($request){
        return Validator::make($request, array(
            'lastname' => 'max:255',
            'name' => 'max:255',
            'fathers_name' => 'max:255',
            'children_names' => 'max:255',
            'origin_country' => 'max:255',
            'ethnic_group' => 'max:255',
            'birthday' => 'date',
            'telephone' => 'digits:10',
            'comments' => 'max:2000',
            'session_date' => 'date',
            'session_comments' => 'max:2000',
        ));
    }

    public function saveSocialFolderToDB($request){
        //TODO after social table creation!!!
    }
}
