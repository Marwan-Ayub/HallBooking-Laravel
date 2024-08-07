<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class hall extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_hall',
        'hall_type',
        'hall_location',
        'size',
        'faculty_id',
        'department_id',
    ];

    public function isAvailable($startTime, $endTime,$endDate)
    {
        // dd($date);

        // Check if there are any bookings for this hall during the specified time period
        $bookings = $this->hallBooks()->where(function ($query) use ($startTime, $endTime,$endDate) {
            $query->where('time_start', '=', $startTime)
            ->where('date_end', '=', $endDate)
            ->where('time_end', '=', $endTime);
        })->get();

        // Check if there are any bookings in the specified time period
        if ($bookings->isNotEmpty()) {
            // If any booking has is_available set to false, hall is not available
            return $bookings->contains('is_available', false) ? true : false;
        }

        // If no bookings found, hall is available
        return true;
    }

    public function hallBooks()
    {
        return $this->hasMany(hall_books::class);
    }

    public function faculty(){
        return $this->hasOne('App\Models\faculty','id','faculty_id');
    }

    public function department(){
        return $this->hasOne('App\Models\department','id','department_id');
    }


}
