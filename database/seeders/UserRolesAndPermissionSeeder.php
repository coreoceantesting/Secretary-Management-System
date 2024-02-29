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

        $dmc->syncPermissions(['agenda.view', 'question.view', 'question.create', 'question.edit', 'question.delete']);


        $mayor = Role::where('name', 'Mayor')->first();

        $mayor->syncPermissions(['agenda.view', 'question.view', 'question.create', 'question.edit', 'question.delete']);



        $department = Role::where('name', 'Department')->first();

        $department->syncPermissions(['goshwara.view', 'goshwara.create', 'goshwara.edit', 'goshwara.delete', 'goshwara.sent']);



        $homeDepartment = Role::where('name', 'Home Department')->first();

        $homeDepartment->syncPermissions(['goshwara.view', 'agenda.view', 'agenda.create', 'agenda.edit', 'agenda.delete', 'schedule_meeting.view', 'schedule_meeting.create', 'schedule_meeting.edit', 'schedule_meeting.delete', 'question.view']);
    }
}
