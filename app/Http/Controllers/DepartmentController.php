<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\department;
use App\Models\faculty;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = department::orderBy('faculty_id')->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $faculties = faculty::all();
        return view('admin.departments.create',compact('faculties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_dep' => ['required', 'string', 'max:255'],
            'faculty_id' => ['required', 'exists:faculties,id'],
        ]);

        department::create($validated);

        return redirect()->route('admin.departments.index')->with('message', 'Department created successfully');
    }

    public function edit($id)
    {
        $department = department::findOrFail($id);
        $faculties = faculty::all();
        return view('admin.departments.edit', compact('department','faculties'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name_dep' => ['required', 'string', 'max:255'],
            'faculty_id' => ['required', 'exists:faculties,id'],
        ]);

        $department = department::findOrFail($id);
        $department->update($validated);

        return redirect()->route('admin.departments.index')->with('message', 'Department updated successfully');
    }

    public function destroy($id)
    {
        $department = department::findOrFail($id);
        $department->delete();

        return back()->with('message', 'Department deleted successfully');
    }
}
