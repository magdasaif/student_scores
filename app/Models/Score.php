<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //====================================================
    protected $fillable = [
        'score',
        'sort',
        'subject_id'
    ];
    //====================================================
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    //====================================================
}
