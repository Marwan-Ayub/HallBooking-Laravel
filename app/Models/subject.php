<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_sub',
        'user_id',
        'department_id',
    ];

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
    public function department(){
        return $this->hasOne('App\Models\department','id','department_id');
    }

}
