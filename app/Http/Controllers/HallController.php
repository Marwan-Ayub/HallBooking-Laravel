<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\department;
use App\Models\faculty;
use App\Models\hall;

class HallController extends Controller
{

    public function index()
    {
        $halls = hall::orderBy('department_id')->paginate(10); // Change 10 to your desired pagination limit;
        return view('admin.halls.index', compact('halls'));
    }


    public function create()
    {
        $faculties = faculty::all();
        $departments = department::all();
        return view('admin.halls.create',compact('faculties','departments'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_hall' => ['required', 'string', 'max:255'],
            'hall_type' => ['required', 'string', 'max:255'],
            'hall_location' => ['required', 'string', 'max:255'],
            'size' => ['required', 'numeric', 'max:255'],
            'faculty_id' => ['required' ],
            'department_id' => ['required'],
        ]);

        hall::create($validated);

        return redirect()->route('admin.halls.index')->with('message', 'Hall created successfully');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $hall = hall::findOrFail($id);
        $departments = department::all();
        $faculties = faculty::all();
        return view('admin.halls.edit', compact('hall','faculties','departments'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name_hall' => ['required', 'string', 'max:255'],
            'hall_type' => ['required', 'string', 'max:255'],
            'hall_location' => ['required', 'string', 'max:255'],
            'size' => ['required', 'numeric', 'max:255'],
            'faculty_id' => ['required' ],
            'department_id' => ['required'],
        ]);

        $hall = hall::findOrFail($id);
        $hall->update($validated);

        return redirect()->route('admin.halls.index')->with('message', 'Hall updated successfully');
    }


    public function destroy($id)
    {
        $hall = hall::findOrFail($id);
        $hall->delete();

        return back()->with('message', 'Hall deleted successfully');
    }
}
