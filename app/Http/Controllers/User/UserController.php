<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignUserRoleRequest;
use App\Http\Requests\ChangeUserPasswordRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Meeting;
use App\Models\ElectionMeeting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\UserElectionMeeting;
use App\Models\UserMeeting;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereNot('id', Auth::user()->id)->latest()->get();

        $roles = Role::whereNot('name', 'like', '%super%')->get();

        $meetings = Meeting::get();

        $electionMeetings = ElectionMeeting::get();

        return view('user.users')->with(['users' => $users, 'roles' => $roles, 'meetings' => $meetings, 'electionMeetings' => $electionMeetings]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->validated();
            $input['password'] = Hash::make($input['password']);
            $input['dob'] = date('Y-m-d', strtotime($input['dob']));
            $input['active_status'] = $request->active_status;
            $user = User::create(Arr::only($input, Auth::user()->getFillable()));
            DB::table('model_has_roles')->insert(['role_id' => $input['role'], 'model_type' => 'App\Models\User', 'model_id' => $user->id]);

            if ($request->role_id == 7) {
                if (isset($request->election_meeting_id)) {
                    for ($i = 0; $i < count($request->election_meeting_id); $i++) {
                        UserElectionMeeting::create([
                            'user_id' => $user->id,
                            'election_meeting_id' => $request->election_meeting_id[$i]
                        ]);
                    }
                }

                if (isset($request->meeting_id)) {
                    for ($i = 0; $i < count($request->meeting_id); $i++) {
                        UserMeeting::create([
                            'user_id' => $user->id,
                            'meeting_id' => $request->meeting_id[$i]
                        ]);
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => 'User created successfully!']);
        } catch (\Exception $e) {
            return $this->respondWithAjax($e, 'creating', 'User');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::whereNot('name', 'like', '%super%')->get();
        $user->loadMissing('roles');

        if ($user) {

            $roleHtml = '<span>
                <option value="">--Select Role --</option>';
            foreach ($roles as $role) :
                $is_select = $role->id == $user->roles[0]->id ? "selected" : "";
                $roleHtml .= '<option value="' . $role->id . '" ' . $is_select . '>' . $role->name . '</option>';
            endforeach;
            $roleHtml .= '</span>';

            $departmentHtml = "";

            if ($user->department_id) {
                $isDepartment = $user->roles[0]->name == "Department" ? '0' : '1';
                $departments = Department::where('is_home_department', $isDepartment)->select('id', 'name')->latest()->get();

                $departmentHtml .= '<label class="col-form-label" for="department_id">Select Department <span class="text-danger">*</span></label>
                <select class="form-select col-sm-12" id="department_id" name="department_id">
                    <option value="">--Select Department--</option>';
                foreach ($departments as $department) :
                    $isDepartmentSelect = ($user->department_id && $user->department_id == $department->id) ? "selected" : "";
                    $departmentHtml .= '<option value="' . $department->id . '" ' . $isDepartmentSelect . '>' . $department->name . '</option>';
                endforeach;
                $departmentHtml .= '</select>
                <span class="text-danger is-invalid department_id_err"></span>';
            }

            $meetingHtml = "";
            $electionMeetingHtml = "";
            if ($user->roles[0]->id == 7) {
                $userMeetings = UserMeeting::where('user_id', $user->id)->pluck('meeting_id')->toArray();
                $meetings = Meeting::select('id', 'name')->get();

                foreach ($meetings as $meeting) {
                    $selected = "";
                    if (in_array($meeting->id, $userMeetings)) {
                        $selected = "selected";
                    }
                    $meetingHtml .= '<option ' . $selected . ' value="' . $meeting->id . '">' . $meeting->name . '</option>';
                }


                $electionUserMeetings = UserElectionMeeting::where('user_id', $user->id)->pluck('election_meeting_id')->toArray();
                $electionMeetings = ElectionMeeting::select('id', 'name')->get();

                foreach ($electionMeetings as $electionMeeting) {
                    $selected = "";
                    if (in_array($electionMeeting->id, $electionUserMeetings)) {
                        $selected = "selected";
                    }
                    $electionMeetingHtml .= '<option ' . $selected . ' value="' . $electionMeeting->id . '">' . $electionMeeting->name . '</option>';
                }
            }

            $response = [
                'result' => 1,
                'user' => $user,
                'roleHtml' => $roleHtml,
                'departmentHtml' => $departmentHtml,
                'meetingHtml' => $meetingHtml,
                'electionMeetingHtml' => $electionMeetingHtml
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $input = $request->validated();
            $input['active_status'] = $request->active_status;
            $user->update(Arr::only($input, Auth::user()->getFillable()));
            $user->roles()->detach();
            DB::table('model_has_roles')->insert(['role_id' => $input['role'], 'model_type' => 'App\Models\User', 'model_id' => $user->id]);

            UserElectionMeeting::where('user_id', $user->id)->delete();
            UserMeeting::where('user_id', $user->id)->delete();
            if ($request->role == 7) {
                if (isset($request->election_meeting_id)) {
                    for ($i = 0; $i < count($request->election_meeting_id); $i++) {
                        UserElectionMeeting::create([
                            'user_id' => $user->id,
                            'election_meeting_id' => $request->election_meeting_id[$i]
                        ]);
                    }
                }

                if (isset($request->meeting_id)) {
                    for ($i = 0; $i < count($request->meeting_id); $i++) {
                        UserMeeting::create([
                            'user_id' => $user->id,
                            'meeting_id' => $request->meeting_id[$i]
                        ]);
                    }
                }
            }
            DB::commit();

            return response()->json(['success' => 'User updated successfully!']);
        } catch (\Exception $e) {
            return $this->respondWithAjax($e, 'updating', 'User');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function toggle(Request $request, User $user)
    {
        $current_status = DB::table('users')->where('id', $user->id)->value('active_status');
        try {
            DB::beginTransaction();
            if ($current_status == '1') {
                User::where('id', $user->id)->update(['active_status' => '0']);
            } else {
                User::where('id', $user->id)->update(['active_status' => '1']);
            }
            DB::commit();
            return response()->json(['success' => 'User status updated successfully']);
        } catch (\Exception $e) {
            return $this->respondWithAjax($e, 'changing', 'User\'s status');
        }
    }

    public function retire(Request $request, User $user)
    {
        try {
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return response()->json(['success' => 'Employee retired successfully']);
        } catch (\Exception $e) {
            return $this->respondWithAjax($e, 'changing', 'Employee\'s retirement status');
        }
    }

    public function changePassword(ChangeUserPasswordRequest $request, User $user)
    {
        $input = $request->validated();
        try {
            DB::beginTransaction();
            $user->update(['password' => Hash::make($input['new_password'])]);
            DB::commit();
            return response()->json(['success' => 'Password updated successfully']);
        } catch (\Exception $e) {
            return $this->respondWithAjax($e, 'changing', 'User\'s password');
        }
    }


    public function getRole(User $user)
    {
        $user->load('roles');
        if ($user) {
            $roles = Role::orderBy('id', 'DESC')->get();
            $roleHtml = '<span>
                <option value="">--Select Role--</option>';
            foreach ($roles as $role) :
                $is_select = $role->id == $user->roles[0]->id ? "selected" : "";
                $roleHtml .= '<option value="' . $role->id . '" ' . $is_select . '>' . $role->name . '</option>';
            endforeach;
            $roleHtml .= '</span>';

            $response = [
                'result' => 1,
                'user' => $user,
                'roleHtml' => $roleHtml,
            ];
        } else {
            $response = ['result' => 0];
        }
        return $response;
    }


    public function assignRole(User $user, AssignUserRoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $user->roles()->detach();
            DB::table('model_has_roles')->insert(['role_id' => $request->edit_role, 'model_type' => 'App\Models\User', 'model_id' => $user->id]);
            DB::commit();
            return response()->json(['success' => 'Role updated successfully']);
        } catch (\Exception $e) {
            return $this->respondWithAjax($e, 'changing', 'User\'s role');
        }
    }

    // function to getDepartment
    public function getDepartment(Request $request, $id)
    {
        if ($request->ajax()) {
            return Department::where('is_home_department', $id)->select('id', 'name')->latest()->get();
        }
    }
}
