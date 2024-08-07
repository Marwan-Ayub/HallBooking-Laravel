<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hall_books extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_id',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'is_available',
        'hall_id',
        'department_id',
        'faculty_id',
    ];

    public function hall()
    {
        return $this->belongsTo(hall::class);
    }

    // public function hall(){
    //     return $this->hasOne('App\Models\hall','id','hall_id');
    // }
    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
    public function subject(){
        return $this->hasOne('App\Models\subject','id','subject_id');
    }
    public function userSubject(){
        return $this->hasOne('App\Models\userSubject','id','subject_id');
    }
    public function department(){
        return $this->hasOne('App\Models\department','id','department_id');
    }
    public function faculty(){
        return $this->hasOne('App\Models\faculty','id','faculty_id');
    }
}
