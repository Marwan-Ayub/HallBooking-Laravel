<?php

namespace App\Http\Controllers;

use App\Models\subject;
use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = subject::orderBy('department_id')->paginate(10);
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = department::all();
        return view('admin.subjects.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_sub' => ['required', 'string', 'max:255'],
            'department_id' => ['required'],
        ]);
        $fill = [
            'name_sub' => $request->name_sub,
            'user_id' => Auth::id(),
            'department_id' => $request->department_id,
        ];

        subject::create($fill);

        return redirect()->route('admin.subjects.index')->with('message', 'Subject created successfully');
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
        $subject = subject::findOrFail($id);
        $departments = department::all();
        return view('admin.subjects.edit', compact('departments','subject'));
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
        $validated = $request->validate([
            'name_sub' => ['required', 'string', 'max:255'],
            'department_id' => ['required'],
        ]);
        $fill = [
            'name_sub' => $request->name_sub,
            'user_id' => Auth::id(),
            'department_id' => $request->department_id,
        ];

        $subject = subject::findOrFail($id);
        $subject->update($fill);

        return redirect()->route('admin.subjects.index')->with('message', 'Subject updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = subject::findOrFail($id);
        $subject->delete();

        return back()->with('message', 'Subject deleted successfully');
    }
}
