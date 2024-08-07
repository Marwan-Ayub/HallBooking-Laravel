<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userSubject extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'subject_id',
    ];

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
    public function subject(){
        return $this->hasOne('App\Models\subject','id','subject_id');
    }
}
