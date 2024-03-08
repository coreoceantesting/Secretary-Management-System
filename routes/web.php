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
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ScheduleMeetingController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RescheduleMeetingController;
use App\Http\Controllers\SuplimentryAgendaController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProceedingRecordController;
use App\Http\Controllers\TharavController;

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
    Route::get('users/{isHomeDepartment}/get-department', [UserController::class, 'getDepartment'])->name('users.get-department');

    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('department', DepartmentController::class);
        Route::resource('home-department', HomeDepartmentController::class);
        Route::resource('ward', WardController::class);
        Route::resource('member', MemberController::class);
        Route::resource('meeting', MeetingController::class);
    });

    Route::get('goshwara/send', [GoshwaraController::class, 'send'])->name('goshwara.send');
    Route::post('goshwara/send', [GoshwaraController::class, 'postSend'])->name('goshwara.post-send');
    Route::resource('goshwara', GoshwaraController::class);

    Route::resource('agenda', AgendaController::class);
    Route::post('schedule-meeting/{id}/cancel', [ScheduleMeetingController::class, 'cancel'])->name('schedule-meeting.cancel');
    Route::resource('schedule-meeting', ScheduleMeetingController::class);

    Route::get('question/schedule_meeting/{id}', [QuestionController::class, 'getScheduleMeeting'])->name('question.getScheduleMeeting');
    Route::post('question/response', [QuestionController::class, 'response'])->name('question.response');
    Route::resource('question', QuestionController::class);

    Route::get('reschedule-meeting/schedule_meeting/{id}', [RescheduleMeetingController::class, 'getScheduleMeeting'])->name('reschedule-meeting.getScheduleMeeting');
    Route::get('reschedule-meeting/get-schedule_meeting-details/{id}', [RescheduleMeetingController::class, 'getScheduleMeetingDetails'])->name('reschedule-meeting.getScheduleMeetingDetails');
    Route::resource('reschedule-meeting', RescheduleMeetingController::class);

    Route::resource('suplimentry-agenda', SuplimentryAgendaController::class);

    Route::post('attendance/update/singleMark', [AttendanceController::class, 'saveSingleMark'])->name('attendance.saveSingleMark');
    Route::resource('attendance', AttendanceController::class);

    Route::get('proceeding-record/getScheduleMeeting/{id}', [ProceedingRecordController::class, 'getScheduleMeeting'])->name('proceeding-record.getScheduleMeeting');
    Route::resource('proceeding-record', ProceedingRecordController::class);

    Route::get('tharav/getScheduleMeeting/{id}', [TharavController::class, 'getScheduleMeeting'])->name('tharav.getScheduleMeeting');
    Route::resource('tharav', TharavController::class);
});




Route::get('/php', function (Request $request) {
    if (!auth()->check())
        return 'Unauthorized request';

    Artisan::call($request->artisan);
    return dd(Artisan::output());
});
