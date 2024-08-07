<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\hall_books;



class UpdateExpireBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateExpireBooking';

    protected $description = 'Command description';


    public function handle()
    {
        // Get current date and time in the specified timezone (Asia/Baghdad)
        //$currentDateTime= Carbon::now('Asia/Baghdad');

        // Get bookings that have both expired date and time
        // $expiredBookings = Booking::where('date_end', '<', Carbon::now('Asia/Baghdad'))
        //     ->orWhere(function ($query) use ($currentDateTime) {
        //         $query->where('date_end', '=', Carbon::now('Asia/Baghdad'))
        //             ->where('time_start', '<', Carbon::now('Asia/Baghdad'));
        //     })
        //     ->get();

        //check if time up in that time will be available for another user to booking

        //for Date
        $date = Carbon::now('Asia/Baghdad')->format('Y-m-d');
        // For Time
        $time = Carbon::now('Asia/Baghdad')->format('H:i:s');

        $expiredBookings = hall_books::where(function ($query) use ($time,$date) {
            $query->where('time_end', '<', $time)
            ->where('date_end', '<=', $date);
        })->get();

        // $expiredBookings = hall_books::where(function ($query) use ($time,$date) {
        //     $query->where('date_end', '<', $date);
        // })->get();

        foreach ($expiredBookings as $booking) {
            $booking->is_available = 0;
            $booking->delete();
        }

        $this->info('Expired bookings updated successfully.');
    }

    public function __construct()
    {
        parent::__construct();
    }
}
