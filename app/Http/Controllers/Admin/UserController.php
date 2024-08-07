<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\faculty;
use App\Models\subject;
use App\Models\userSubject;
use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        $departments = department::all();
        $faculties = faculty::all();
        $subjects = subject::all();
        return view('admin.users.create', compact('departments', 'faculties','subjects'));
    }
    public function update($id , Request $request)
    {

        // Retrieve user data
        $dataUser = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            // 'password' => ['required', Rules\Password::defaults()],
            'department' => ['required', 'numeric', 'max:50'],
            'faculty' => ['required', 'numeric', 'max:50'],
        ]);

        // Hash the password before updating the user
        // $validated['password'] = Hash::make($validated['password']);

        // $user = User::findOrFail($id);
        User::where('id',$id)->update([
            'name' => $request->name,
            'email' => $request->email,
            // 'password' =>Hash::make($request->password),
            'password' => $dataUser->password,
            'department_id' => $request->department,
            'faculty_id' => $request->faculty,
        ]);
        // $user->update($validated);

        return back()->with('message', 'User Updated.');
    }
    public function store(Request $request): RedirectResponse
    {
        // find user to add subject

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'department' => ['required', 'numeric', 'max:50'],
            'faculty' => ['required', 'numeric', 'max:50'],
            'subject' => ['required', 'numeric', 'max:50'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'department_id' => $request->department,
            'faculty_id' => $request->faculty,
        ]);

        $userId = User::findOrFail($user->id);
        userSubject::create([
            'user_id' => $userId->id,
            'subject_id' => $request->subject,
        ]);

        event(new Registered($user));     // enable email verification

        return to_route('admin.users.index')->with('message', 'User Created successfully.');
    }
    public function deleteSubject($subjectId)
    {
        $subject = userSubject::findOrFail($subjectId);
        $subject->delete();
        return back()->with('message', 'Subject deleted.');
    }
    public function storeSubject($userId,Request $request)
    {
        // find user to add subject
        $user = User::findOrFail($userId);

        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
        ]);

        // Check if the subject already exists for the user
        $CheckSubject = userSubject::where('user_id', $user->id)
        ->where('subject_id', $request->subject)
        ->exists();

        if ($CheckSubject) {
            return back()->with('message', 'Subject already assigned.');
        }

        userSubject::create([
            'user_id' => $user->id,
            'subject_id' => $request->subject,
        ]);

        return back()->with('message', 'Subject assigned.');
    }

    public function show(User $user)
    {

        $roles = Role::all();
        $permissions = Permission::all();
        $departments = department::all();
        $faculties = faculty::all();
        $subjects = subject::where('department_id',$user->department_id)->get();
        $subjectUsers = userSubject::where('user_id',$user->id)->get();

        // Decrypt the password before showing the user
        //  $user->password = Crypt::decrypt($user->password);

        return view('admin.users.role', compact('user', 'roles', 'permissions','departments','faculties','subjects','subjectUsers'));
    }

    public function assignRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $user->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            return back()->with('message', 'Role removed.');
        }

        return back()->with('message', 'Role not exists.');
    }

    public function givePermission(Request $request, User $user)
    {
        if ($user->hasPermissionTo($request->permission)) {
            return back()->with('message', 'Permission exists.');
        }
        $user->givePermissionTo($request->permission);
        return back()->with('message', 'Permission added.');
    }

    public function revokePermission(User $user, Permission $permission)
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return back()->with('message', 'Permission revoked.');
        }
        return back()->with('message', 'Permission does not exists.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('Admin')) {
            return back()->with('message', 'The user is admin.');
        }
        $user->delete();

        return back()->with('message', 'User deleted.');
    }
}
