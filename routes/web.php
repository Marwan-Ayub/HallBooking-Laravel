<?php

use Carbon\Carbon;
use App\Models\hall_books;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\HallBooksController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\PermissionController;


Auth::routes([
    'verify' => true // enable email verification
]);

// Route::get('/index/{day?}', 'YourController@index')->name('index');
// Route::get('/next-day/{day}', 'YourController@nextDay')->name('nextDay');
// Route::get('/previous-day/{day}', 'YourController@previousDay')->name('previousDay');

// Route::get('/', [StudentController::class,'indexStudent'])->name('indexStudent');

Route::get('/', function(){
    // Get the current date in Asia/Baghdad timezone
    $date_now = Carbon::now('Asia/Baghdad')->format('Y-m-d');
    // Query hall bookings based on the selected date
    $hallBooks = hall_books::where('date_end', '=', $date_now)->get();
    //  // If $day is provided and is a valid date, parse it; otherwise, default to today's date
    //  $currentDay = $day ? Carbon::parse($day, 'Asia/Baghdad') : Carbon::now('Asia/Baghdad');

    //  // Query hall bookings based on the selected date
    //  $hallBooks = hall_books::where('date_end', '=', $currentDay->toDateString())->get();

    //  // Calculate the previous and next days
    //  $previousDay = $currentDay;
    //  $nextDay = $currentDay;

    return view('welcome', compact('hallBooks'));
})->name('welcome');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/hall', HallBooksController::class);
    Route::get('/hallDay/{day}', [HallBooksController::class,'index2'])->name('hall.index2');
    Route::get('/next-day/{day}', [HallBooksController::class,'nextDay'])->name('nextDay');
    Route::get('/previous-day/{day}', [HallBooksController::class,'previousDay'])->name('previousDay');
});



Route::middleware(['auth', 'role:Admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('/departments', DepartmentController::class);
    Route::resource('/faculties', FacultyController::class);
    Route::resource('/times', TimeController::class);
    Route::resource('/halls', HallController::class);
    Route::resource('/subjects', SubjectController::class);

    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

    Route::post('/users/{user}/subject', [UserController::class, 'storeSubject'])->name('users.storeSubject');
    Route::post('/users/{user}/deleteSubject', [UserController::class, 'deleteSubject'])->name('users.deleteSubject');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');
});

require __DIR__ . '/auth.php';
