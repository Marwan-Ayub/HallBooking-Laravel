<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\hall;
use App\Models\User;
use App\Models\faculty;
use App\Models\subject;
use App\Models\time;
use App\Models\department;
use App\Models\hall_books;
use App\Models\userSubject;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class HallBooksController extends Controller
{

    // public function index($day = null,Request $request){
    //     // Get today's date in Asia/Baghdad timezone
    //     // $currentDay = Carbon::now('Asia/Baghdad');

    //     // Query hall bookings based on today's date
    //     // $hallBooks = hall_books::where('date_end', '=', $currentDay->toDateString())->get();



    //     // return view('welcome', compact('currentDay', 'previousDay', 'nextDay', 'hallBooks'));

    //     $halls = hall::all();
    //     $times = time::all();
    //     $userSubjects = userSubject::where('user_id',Auth::id())->get();

    //     // Get the current date in Asia/Baghdad timezone
    //     // $date_now = Carbon::now('Asia/Baghdad')->format('Y-m-d');
    //         // If $day is provided and is a valid date, parse it; otherwise, default to today's date
    // $date_now = $day ? Carbon::parse($day, 'Asia/Baghdad')->format('Y-m-d') : Carbon::now('Asia/Baghdad')->format('Y-m-d');

    //     // Check if a specific day is provided, otherwise use the current date
    //     $date_select = $request->date_end ? $request->date_end : $date_now;

    //     // Query hall bookings based on the selected date
    //     $hallBooks = hall_books::where('date_end', '=', $date_select)->get();
    //     // Calculate the previous and next days
    //     $previousDay = $date_now->copy()->subDay();
    //     $nextDay = $date_now->copy()->addDay();

    //     return view('hall.index', compact('halls','hallBooks','times','date_select','userSubjects','date_now','previousDay','nextDay'));
    // }
    public function index2($day = null,Request $request){
        $halls = hall::all();
        $times = time::all();
        $subjects = subject::all();
        $userSubjects = userSubject::where('user_id',Auth::id())->get();

        if ($day == 'day') {
            $day = null;
        }

        // Get the current date in Asia/Baghdad timezone
        $date_now = Carbon::now('Asia/Baghdad')->format('Y-m-d');

        // If $day is provided and is a valid date, parse it; otherwise, default to today's date
        $date_now2 = $day ? Carbon::parse($day, 'Asia/Baghdad') : Carbon::now('Asia/Baghdad');

        // Check if a specific day is provided, otherwise use the current date
        $date_select = $request->date_end ? $request->date_end : $date_now2;

        $date_select = Carbon::parse($date_select, 'Asia/Baghdad')->format('Y-m-d');
        // Query hall bookings based on the selected date
        $hallBooks = hall_books::where('date_end', '=', $date_select)->get();

        // Calculate the previous and next days
        $date_select = Carbon::parse($date_select, 'Asia/Baghdad');
        $previousDay = $date_select->copy();
        $nextDay = $date_select->copy();

        return view('hall.index', compact('halls','hallBooks','times','date_select','userSubjects','subjects','date_now','date_now2','previousDay','nextDay'));
    }
    public function nextDay($day)
    {
        // Parse the current day parameter to a Carbon instance
        $date_now = Carbon::parse($day)->addDay();

        // Redirect to the index page with the next day parameter
        return redirect()->route('hall.index2', ['day' => $date_now->format('Y-m-d')]);
    }

    public function previousDay($day)
    {
        // Parse the current day parameter to a Carbon instance
        $date_now = Carbon::parse($day)->subDay();

        // Redirect to the index page with the previous day parameter
        return redirect()->route('hall.index2', ['day' => $date_now->format('Y-m-d')]);
    }

    public function show($userId){

        if (Auth::id() != $userId) {
            return back();
        }

        // $hallBooks = hall_books::with(['user_id' ,'1'])->get();
        $hallBooks = hall_books::where(['user_id'=> $userId, 'is_available' => '1'])->get();

        return view('hall.hall_show', compact('hallBooks'));
    }

    // not working
    public function create(Request $request) {
        $times = time::all();
        $time = $times->find($request->timeId);
        $halls = hall::all();
        $hall = $halls->find($request->hallId);
        $hallBooks = hall_books::all();
        $subjects = subject::all();
        return view('hall.hall_form', compact('subjects','hall','hallBooks','time','date_start'));
    }

    //not working
    public function edit($id){

        // check user if do not change id in url
        // $checkUser = hall_books::find($id);
        // if (Auth::id() != $checkUser->user_id) {
        //     return back();
        // }

        $subjects = subject::all();
        $hallEdit = hall_books::find($id);
        return view('hall.hall_edit', compact('hallEdit','subjects'));
    }

    public function update($id){

        // check user if do not change id in url to another user
        // $checkUser = hall_books::find($id);
        // if (Auth::id() != $checkUser->user_id) {
        //     return back();
        // }

        // $dataUser = Auth::user();
        // $fill = [
        //     'user_id' => $dataUser->id,
        //     'subject_id' => $request->subject,
        //     'date_start' => $request->dateStart,
        //     'time_start' => $request->timeStart,
        //     'date_end' => $request->dateEnd,
        //     'time_end' => $request->timeEnd,
        //     'is_available' => $request->is_available,
        //     'hall_id' => $request->hall,
        //     'department_id' => $dataUser->department_id,
        //     'faculty_id' => $dataUser->faculty_id,
        // ];


        // $hallBook = hall_books::where('id',$id)->delete();

        // return redirect()->route('hall.show');
    }

    public function store(Request $request)
    {

        //validate request data
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|string|max:255',
            'hall_id' => 'required|string|min:8',
            'date_start' =>  'required|date',
            'date_end'   =>  'required|date|after_or_equal:date_start',
            'time_start' =>  'required|date_format:H:i',
            'time_end'   =>  'required|date_format:H:i|time_after_or_equal:time_start',
        ]);

    // If validation fails
    // if ($validator->fails()) {
    //     return redirect()->route('hall.index')->withErrors($validator)->withInput();
    // }

    // Retrieve user data
    $dataUser = Auth::user();

    // Loop over the selected number of weeks and make bookings
    $numWeeks = $request->input('num_weeks');
    $dateStart = Carbon::parse($request->input('dateStart'));
    $dateEnd = Carbon::parse($request->input('dateEnd'));
    $errors =[];

    for ($i = 0; $i < $numWeeks; $i++) {
        // Adjust date for each week
        // $fill['date_start'] = $dateStart->format('Y-m-d');
        $date_end = $dateEnd->format('Y-m-d');
    if ($request->timeStart) {
        $fill[$i] = [
            'user_id' => $dataUser->id,
            'subject_id' => $request->subject,
            'date_start' => $request->dateStart,
            'date_end' => $date_end,
            'time_start' => $request->timeStart,
            'time_end' => $request->timeEnd,
            'is_available' => '1',
            'hall_id' => $request->hall,
            'department_id' => $dataUser->department_id,
            'faculty_id' => $dataUser->faculty_id,
        ];
    }else {
        $fill[$i] = [
            'user_id' => $dataUser->id,
            'subject_id' => $request->subject,
            'date_start' => $request->dateStart,
            'date_end' => $date_end,
            'time_start' => $request->timeStartNight,
            'time_end' => $request->timeEndNight,
            'is_available' => '1',
            'hall_id' => $request->hallNight,
            'department_id' => $dataUser->department_id,
            'faculty_id' => $dataUser->faculty_id,
        ];
    };
        // Check if the booking already exists for the selected week
        $existingBooking = hall_books::where([
            'hall_id' => $fill[$i]['hall_id'],
            'time_start' => $fill[$i]['time_start'],
            'time_end' => $fill[$i]['time_end'],
            // 'date_start' => $fill[$i]['date_start'],
            'date_end' => $fill[$i]['date_end'],
        ])->exists();

        // If booking does not exist, create a new booking
        if (!$existingBooking) {
            hall_books::create($fill[$i]);
        }else{
            $errors[$i]= "In date ".$date_end." booking already exists";
        }

        // Move to the next week
        // $dateStart->addWeek();
        $dateEnd->addWeek();
    }

        return redirect()->route('hall.index2','day')->withErrors($errors)->with([
            'Result' => 'The Booking Was Success',
        ]);
    }



    //     //validate request data
    //     $validator = Validator::make($request->all(), [
    //         'subject_id' => 'required|string|max:255',
    //         'hall_id' => 'required|string|min:8',
    //         'date_start' =>  'required|date',
    //         'time_start' =>  'required|date_format:H:i',
    //         'date_end'   =>  'required|date|after_or_equal:date_start',
    //         'time_end'   =>  'required|date_format:H:i|time_after_or_equal:time_start',
    //     ]);

        // $dataUser = Auth::user();

    //     $fill = [
    //         'user_id' => $dataUser->id,
    //         'subject_id' => $request->subject,
    //         'date_start' => $request->dateStart,
    //         'time_start' => $request->timeStart,
    //         'date_end' => $request->dateEnd,
    //         'time_end' => $request->timeEnd,
    //         'is_available' => '1',
    //         'hall_id' => $request->hall,
    //         'department_id' => $dataUser->department_id,
    //         'faculty_id' => $dataUser->faculty_id,
    //     ];
    //     // $user->password=Hash::make($request->input('password'));

    //         // Check if validation fails
        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }

    //         $hall_books = hall_books::create($fill);
    //         return redirect()->route('hall.index')->with('Result','The Booking Was Success');

    //         // return redirect()->route('hall.index')->withErrors($validator)->withInput();




    public function destroy($id){
        $books = hall_books::find($id)->delete();

        return redirect()->route('hall.show',Auth::id())->with('Result', 'Books deleted successfully');

        // return redirect()->route('hall.show');

    }
}
