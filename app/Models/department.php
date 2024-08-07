<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_dep',
        'faculty_id',
    ];

    public function faculty(){
        return $this->hasOne('App\Models\faculty','id','faculty_id');
    }
}
