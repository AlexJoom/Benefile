<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsychosocialSession extends Model
{
	use SoftDeletes;
	
    protected $table = 'psychosocial_sessions';
	protected $dates = ['deleted_at'];
	protected $fillable = ['session_date', 'session_comments', 'social_folder_id', 'psychosocial_theme_id', 'psychologist_id'];

    public function supportType(){
        return $this->hasOne('App\Models\Psychosocial_support_lookup', 'id', 'psychosocial_theme_id');
    }
}
