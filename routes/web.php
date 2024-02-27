<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\MeetingController;
use App\Http\Controllers\Master\WardController;
use App\Http\Controllers\Master\MemberController;
use App\Http\Controllers\Master\HomeDepartmentController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoshwaraController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('/');




// Guest Users
Route::middleware(['guest', 'PreventBackHistory'])->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('signin');
    // Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    // Route::post('register', [AuthController::class, 'register'])->name('signup');
});




// Authenticated users
Route::middleware(['auth', 'PreventBackHistory'])->group(function () {

    // Auth Routes
    Route::get('home', fn () => redirect()->route('dashboard'))->name('home');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'Logout'])->name('logout');
    Route::get('change-theme-mode', [DashboardController::class, 'changeThemeMode'])->name('change-theme-mode');
    Route::get('show-change-password', [AuthController::class, 'showChangePassword'])->name('show-change-password');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('change-password');



    // Masters
    Route::resource('wards', App\Http\Controllers\Admin\Masters\WardController::class);




    // Users Roles n Permissions
    Route::resource('users', UserController::class);
    Route::get('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
    Route::get('users/{user}/retire', [UserController::class, 'retire'])->name('users.retire');
    Route::put('users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::get('users/{user}/get-role', [UserController::class, 'getRole'])->name('users.get-role');
    Route::put('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::resource('roles', RoleController::class);

    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('department', DepartmentController::class);
        Route::resource('home-department', HomeDepartmentController::class);
        Route::resource('ward', WardController::class);
        Route::resource('member', MemberController::class);
        Route::resource('meeting', MeetingController::class);
    });

    Route::resource('goshwara', GoshwaraController::class);
});




Route::get('/php', function (Request $request) {
    if (!auth()->check())
        return 'Unauthorized request';

    Artisan::call($request->artisan);
    return dd(Artisan::output());
});