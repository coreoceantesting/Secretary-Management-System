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

        $dmc = Role::where('name', 'DMC')->first();

        $dmc->syncPermissions(['dashboard.view', 'agenda.view', 'question.view']);


        $mayor = Role::where('name', 'Mayor')->first();

        $mayor->syncPermissions(['dashboard.view', 'agenda.view', 'question.view']);



        $department = Role::where('name', 'Department')->first();

        $department->syncPermissions(['dashboard.view', 'goshwara.view', 'goshwara.create', 'goshwara.edit', 'goshwara.delete', 'goshwara.send', 'question.response', 'question.view']);



        $homeDepartment = Role::where('name', 'Home Department')->first();

        $homeDepartment->syncPermissions(['dashboard.view', 'goshwara.view', 'agenda.view', 'agenda.create', 'agenda.edit', 'agenda.delete', 'schedule_meeting.view', 'schedule_meeting.create', 'schedule_meeting.edit', 'schedule_meeting.delete', 'question.view', 'question.create', 'question.edit', 'question.delete', 'attendance.view', 'attendance.create', 'attendance.edit', 'attendance.delete', 'reschedule_meeting.view', 'reschedule_meeting.create', 'reschedule_meeting.edit', 'reschedule_meeting.delete', 'suplimentry-agenda.view', 'suplimentry-agenda.create', 'suplimentry-agenda.edit', 'suplimentry-agenda.delete']);
    }
}
