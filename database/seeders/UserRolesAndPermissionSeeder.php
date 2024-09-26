<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::where('name', 'Admin')->first();

        $admin->syncPermissions(['dashboard.view', 'department.view', 'department.create', 'department.edit', 'department.delete', 'home_department.view', 'home_department.create', 'home_department.edit', 'home_department.delete', 'wards.view', 'wards.create', 'wards.edit', 'wards.delete', 'member.view', 'member.create', 'member.edit', 'member.delete', 'meeting.view', 'meeting.create', 'meeting.edit', 'meeting.delete', 'users.view', 'users.create', 'users.edit', 'users.delete', 'users.toggle_status', 'users.change_password', 'roles.view', 'roles.create', 'roles.edit', 'roles.delete', 'roles.assign', 'goshwara.view', 'agenda.view', 'suplimentry-agenda.view', 'schedule_meeting.view', 'schedule_meeting.show', 'reschedule_meeting.view', 'reschedule_meeting.show', 'question.view', 'proceeding-record.show', 'proceeding-record.view', 'tharav.view', 'party.view', 'party.create', 'party.edit', 'party.delete']);

        // $admin = Role::where('name', 'Admin')->first();

        // $admin->syncPermissions(['dashboard.view', 'goshwara.view', 'agenda.view', 'suplimentry-agenda.view', 'schedule_meeting.view', 'schedule_meeting.show', 'reschedule_meeting.view', 'reschedule_meeting.show', 'question.view', 'proceeding-record.show', 'proceeding-record.view', 'tharav.view']);


        $dmc = Role::where('name', 'DMC')->first();

        $dmc->syncPermissions(['dashboard.view', 'goshwara.view', 'agenda.view', 'suplimentry-agenda.view', 'schedule_meeting.view', 'schedule_meeting.show', 'reschedule_meeting.view', 'reschedule_meeting.show', 'question.view', 'laxvadi.view', 'prastav-suchana.view', 'proceeding-record.show', 'proceeding-record.view', 'tharav.view']);


        $mayor = Role::where('name', 'Mayor')->first();

        $mayor->syncPermissions(['dashboard.view', 'agenda.view', 'agenda.edit', 'question.view', 'laxvadi.view', 'prastav-suchana.view', 'goshwara.view', 'tharav.view', 'schedule_meeting.view', 'schedule_meeting.show']);



        $department = Role::where('name', 'Department')->first();

        $department->syncPermissions(['dashboard.view', 'goshwara.view', 'goshwara.create', 'goshwara.edit', 'goshwara.delete', 'goshwara.send', 'agenda.view', 'suplimentry-agenda.view', 'schedule_meeting.view', 'schedule_meeting.show', 'reschedule_meeting.view', 'reschedule_meeting.show', 'question.response', 'question.view', 'laxvadi.response', 'laxvadi.view', 'prastav-suchana.response', 'prastav-suchana.view', 'proceeding-record.show', 'proceeding-record.view', 'tharav.view']);



        $homeDepartment = Role::where('name', 'Home Department')->first();

        $homeDepartment->syncPermissions(['dashboard.view', 'goshwara.view', 'agenda.view', 'agenda.create', 'agenda.edit', 'agenda.delete', 'schedule_meeting.view', 'schedule_meeting.create', 'schedule_meeting.cancel', 'schedule_meeting.show', 'question.view', 'laxvadi.view', 'prastav-suchana.view', 'question.create', 'laxvadi.create', 'prastav-suchana.create', 'question.edit', 'laxvadi.edit', 'prastav-suchana.edit', 'question.delete', 'laxvadi.delete', 'prastav-suchana.delete', 'attendance.view', 'attendance.mark', 'reschedule_meeting.view', 'reschedule_meeting.create', 'reschedule_meeting.cancel', 'reschedule_meeting.show', 'suplimentry-agenda.view', 'suplimentry-agenda.create', 'suplimentry-agenda.edit', 'suplimentry-agenda.delete', 'proceeding-record.show', 'proceeding-record.view', 'proceeding-record.create', 'tharav.view', 'tharav.create', 'agenda.receipt']);



        $admin = Role::where('name', 'Clerk')->first();

        $admin->syncPermissions(['dashboard.view', 'goshwara.view', 'agenda.view', 'agenda.create', 'suplimentry-agenda.view', 'suplimentry-agenda.create', 'schedule_meeting.view', 'schedule_meeting.create', 'schedule_meeting.show', 'reschedule_meeting.view', 'reschedule_meeting.view', 'reschedule_meeting.show', 'attendance.view', 'attendance.mark', 'question.view', 'laxvadi.view', 'prastav-suchana.view', 'question.create', 'laxvadi.create', 'prastav-suchana.create', 'proceeding-record.show', 'proceeding-record.view', 'tharav.view', 'meeting.view', 'meeting.create', 'meeting.edit', 'meeting.delete', 'tharav.view', 'tharav.create']);
    }
}
