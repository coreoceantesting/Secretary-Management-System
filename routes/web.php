<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\MeetingController;
use App\Http\Controllers\Master\WardController;
use App\Http\Controllers\Master\MemberController;
use App\Http\Controllers\Master\PartyController;
use App\Http\Controllers\Master\HomeDepartmentController;
use App\Http\Controllers\Master\SettingController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoshwaraController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ScheduleMeetingController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\PrastavSuchanaController;
use App\Http\Controllers\LaxvadiController;
use App\Http\Controllers\RescheduleMeetingController;
use App\Http\Controllers\SuplimentryAgendaController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProceedingRecordController;
use App\Http\Controllers\TharavController;
use App\Http\Controllers\ReportController;

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
    Route::get('home', fn() => redirect()->route('dashboard'))->name('home');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'Logout'])->name('logout');
    Route::get('change-theme-mode', [DashboardController::class, 'changeThemeMode'])->name('change-theme-mode');
    Route::get('show-change-password', [AuthController::class, 'showChangePassword'])->name('show-change-password');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('change-password');



    // Masters
    Route::resource('wards', App\Http\Controllers\Admin\Masters\WardController::class);




    // route for Users Roles and Permissions
    Route::resource('users', UserController::class);
    Route::get('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
    Route::get('users/{user}/retire', [UserController::class, 'retire'])->name('users.retire');
    Route::put('users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::get('users/{user}/get-role', [UserController::class, 'getRole'])->name('users.get-role');
    Route::put('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assign-role');
    Route::resource('roles', RoleController::class);
    Route::get('users/{isHomeDepartment}/get-department', [UserController::class, 'getDepartment'])->name('users.get-department');
    // end of route for Users Roles and Permissions

    // route for master
    Route::prefix('master')->name('master.')->group(function () {
        Route::resource('department', DepartmentController::class);
        Route::resource('home-department', HomeDepartmentController::class);
        Route::resource('ward', WardController::class);
        Route::resource('member', MemberController::class);
        Route::resource('meeting', MeetingController::class);
        Route::resource('setting', SettingController::class);
        Route::resource('party', PartyController::class);
    });
    // end of route for master

    // route for goshwara
    Route::get('goshwara/send', [GoshwaraController::class, 'send'])->name('goshwara.send');
    Route::post('goshwara/send', [GoshwaraController::class, 'postSend'])->name('goshwara.post-send');
    // Route::get('goshwara/selected-status/{status}', [GoshwaraController::class, 'getSelectedStatus'])->name('goshwara.get-selected-status');
    // Route::post('goshwara/save-mayor-selected-status', [GoshwaraController::class, 'saveMayorSelectedStatus'])->name('goshwara.save-mayor-selected-status');
    Route::resource('goshwara', GoshwaraController::class);
    // end of route for goshwara


    // route for agenda
    Route::get('agenda/meeting/pdf', [AgendaController::class, 'generatePdf'])->name('agenda.generatePdf');
    Route::get('agenda/meeting/select-meeting', [AgendaController::class, 'selectMeeting'])->name('agenda.selectMeeting');
    Route::get('agenda/receipt/{id}', [AgendaController::class, 'receipt'])->name('agenda.receipt');
    Route::resource('agenda', AgendaController::class);

    // route for schedule meeting
    Route::get('schedule-meeting/fetch-agenda-details', [ScheduleMeetingController::class, 'fetchAgendaDetails'])->name('schedule-meeting.fetch-agenda');
    Route::get('schedule-meeting/fetch-agenda-meeting-details', [ScheduleMeetingController::class, 'fetchAgendaMeetingDetails'])->name('schedule-meeting.fetch-agenda-meeting');
    Route::post('schedule-meeting/{id}/cancel', [ScheduleMeetingController::class, 'cancel'])->name('schedule-meeting.cancel');
    Route::resource('schedule-meeting', ScheduleMeetingController::class);
    // end of route for schedule meeting

    // route for question
    Route::get('question/schedule_meeting/{id}', [QuestionController::class, 'getScheduleMeeting'])->name('question.getScheduleMeeting');
    Route::get('question/schedule_meeting/get-department/{id}', [QuestionController::class, 'getScheduleMeetingDepartments'])->name('question.getScheduleMeetingDepartments');
    Route::post('question/response', [QuestionController::class, 'response'])->name('question.response');
    Route::post('question/saveSingleResponse', [QuestionController::class, 'saveSingleResponse'])->name('question.saveSingleResponse');
    Route::post('question/schedule_meeting/mayor-accept', [QuestionController::class, 'acceptMayorQuetion'])->name('question.acceptQuetionByMayor');
    Route::post('question/schedule_meeting/send-question', [QuestionController::class, 'sendQuestionToDepartment'])->name('question.sendQuestion');
    Route::resource('question', QuestionController::class);
    // end of route for question


    // route for prastav suchana
    Route::get('laxvadi/schedule_meeting/{id}', [LaxvadiController::class, 'getScheduleMeeting'])->name('laxvadi.getScheduleMeeting');
    Route::get('laxvadi/schedule_meeting/get-department/{id}', [LaxvadiController::class, 'getScheduleMeetingDepartments'])->name('laxvadi.getScheduleMeetingDepartments');
    Route::post('laxvadi/response', [LaxvadiController::class, 'response'])->name('laxvadi.response');
    Route::post('laxvadi/saveSingleResponse', [LaxvadiController::class, 'saveSingleResponse'])->name('laxvadi.saveSingleResponse');
    Route::post('laxvadi/schedule_meeting/mayor-accept', [LaxvadiController::class, 'acceptMayorQuetion'])->name('laxvadi.acceptQuetionByMayor');
    Route::post('laxvadi/schedule_meeting/send-question', [LaxvadiController::class, 'sendQuestionToDepartment'])->name('laxvadi.sendQuestion');
    Route::resource('laxvadi', LaxvadiController::class);
    // end of route for prastav suchana


    // route for prastav suchana
    Route::get('prastav-suchana/schedule_meeting/{id}', [PrastavSuchanaController::class, 'getScheduleMeeting'])->name('prastav-suchana.getScheduleMeeting');
    Route::get('prastav-suchana/schedule_meeting/get-department/{id}', [PrastavSuchanaController::class, 'getScheduleMeetingDepartments'])->name('prastav-suchana.getScheduleMeetingDepartments');
    Route::post('prastav-suchana/response', [PrastavSuchanaController::class, 'response'])->name('prastav-suchana.response');
    Route::post('prastav-suchana/saveSingleResponse', [PrastavSuchanaController::class, 'saveSingleResponse'])->name('prastav-suchana.saveSingleResponse');
    Route::post('prastav-suchana/schedule_meeting/mayor-accept', [PrastavSuchanaController::class, 'acceptMayorQuetion'])->name('prastav-suchana.acceptQuetionByMayor');
    Route::post('prastav-suchana/schedule_meeting/send-question', [PrastavSuchanaController::class, 'sendQuestionToDepartment'])->name('prastav-suchana.sendQuestion');
    Route::resource('prastav-suchana', PrastavSuchanaController::class);
    // end of route for prastav suchana



    // route for reschedule meeting
    Route::get('reschedule-meeting/schedule_meeting/{id}', [RescheduleMeetingController::class, 'getScheduleMeeting'])->name('reschedule-meeting.getScheduleMeeting');
    Route::get('reschedule-meeting/get-schedule_meeting-details/{id}', [RescheduleMeetingController::class, 'getScheduleMeetingDetails'])->name('reschedule-meeting.getScheduleMeetingDetails');
    Route::resource('reschedule-meeting', RescheduleMeetingController::class);
    // end of route ffor reschedule meeting

    // route for suplimentry agenda
    Route::get('suplimentry-agenda/schedule_meeting/{id}', [SuplimentryAgendaController::class, 'getScheduleMeeting'])->name('suplimentry-agenda.getScheduleMeeting');
    Route::resource('suplimentry-agenda', SuplimentryAgendaController::class);
    // end of route for suplimentry agenda

    // route for attendance
    Route::post('attendance/update/singleMark', [AttendanceController::class, 'saveSingleMark'])->name('attendance.saveSingleMark');
    Route::post('attendance/update/saveDepartmentSingleMark', [AttendanceController::class, 'saveDepartmentSingleMark'])->name('attendance.saveDepartmentSingleMark');
    Route::get('attendance/startMeetingSendSms', [AttendanceController::class, 'startMeetingSendSms'])->name('attendance.startMeetingSendSms');
    Route::resource('attendance', AttendanceController::class);
    // end of route for attendance

    // route for proceeding record
    Route::get('proceeding-record/pdf/{id}', [ProceedingRecordController::class, 'pdf'])->name('proceeding-record.pdf');
    Route::get('proceeding-record/getScheduleMeeting/{id}', [ProceedingRecordController::class, 'getScheduleMeeting'])->name('proceeding-record.getScheduleMeeting');
    Route::resource('proceeding-record', ProceedingRecordController::class);
    // end of route for proceeding record

    // route for tharav
    Route::get('tharav/get-tharav-department/{id}', [TharavController::class, 'getTharavDepartment'])->name('tharav.getTharavDepartment');
    Route::post('tharav/save-department-question', [TharavController::class, 'saveDepartmentQuestion'])->name('tharav.saveDepartmentQuestion');
    Route::get('tharav/get-tharav-department-question/{id}', [TharavController::class, 'getTharavDepartmentQuestion'])->name('tharav.getTharavDepartmentQuestion');

    Route::post('tharav/save-department-question-response', [TharavController::class, 'saveDepartmentQuestionResponse'])->name('tharav.saveDepartmentQuestionResponse');


    // Route::post('tharav/save-department-question', [TharavController::class, 'saveDepartmentQuestion'])->name('tharav.saveDepartmentQuestion');



    Route::get('tharav/getScheduleMeeting/{id}', [TharavController::class, 'getScheduleMeeting'])->name('tharav.getScheduleMeeting');
    Route::get('tharav/get-schedule_meeting-department/{id}', [TharavController::class, 'getScheduleMeetingDepartment'])->name('tharav.getScheduleMeetingDepartment');
    Route::resource('tharav', TharavController::class);
    // end of route for tharav

    // route for report
    Route::get('report/schedule-meeting', [ReportController::class, 'scheduleMeetingReport'])->name('report.schedule-meeting');
    Route::get('report/schedule-meeting/{id}', [ReportController::class, 'viewScheduleMeetingReport'])->name('report.viewScheduleMeetingReport');
    Route::get('report/attendance-meeting', [ReportController::class, 'attendanceMeetingReport'])->name('report.attendance-meeting');
    Route::get('report/tharav', [ReportController::class, 'tharavReport'])->name('report.tharav');
    // end of route for report
});




Route::get('/php', function (Request $request) {
    if (!auth()->check())
        return 'Unauthorized request';

    Artisan::call($request->artisan);
    return dd(Artisan::output());
});
