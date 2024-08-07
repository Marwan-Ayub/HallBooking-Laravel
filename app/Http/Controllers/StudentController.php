<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\hall_books;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexStudent()
    {
        // Get today's date in Asia/Baghdad timezone
        $currentDay = Carbon::now('Asia/Baghdad');

        // Query hall bookings based on today's date
        $hallBooks = hall_books::where('date_end', '=', $currentDay->toDateString())->get();

        // Calculate the previous and next days
        $previousDay = $currentDay;
        $nextDay = $currentDay;

        return view('welcome', compact('currentDay', 'previousDay', 'nextDay', 'hallBooks'));
    }

    public function nextDay($day)
    {
        // Parse the current day parameter to a Carbon instance
        $currentDay = Carbon::parse($day)->addDay();

        // Redirect to the index page with the next day parameter
        return redirect()->route('indexStudent', ['day' => $currentDay->format('Y-m-d')]);
    }

    public function previousDay($day)
    {
        // Parse the current day parameter to a Carbon instance
        $currentDay = Carbon::parse($day)->subDay();

        // Redirect to the index page with the previous day parameter
        return redirect()->route('indexStudent', ['day' => $currentDay->format('Y-m-d')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
