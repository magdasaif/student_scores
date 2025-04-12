<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //====================================================
    protected $fillable = [
        'name',
        'active'
    ];
    //====================================================
    public function scores(){
        return $this->hasMany(Score::class);
    }
    //====================================================
    public function scopeActive($query){
        return $query->where('active',1);
    }
    //====================================================
}
