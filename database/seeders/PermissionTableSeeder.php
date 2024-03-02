<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'id' => 1,
                'name' => 'dashboard.view',
                'group' => 'dashboard',
            ],
            [
                'id' => 2,
                'name' => 'users.view',
                'group' => 'users',
            ],
            [
                'id' => 3,
                'name' => 'users.create',
                'group' => 'users',
            ],
            [
                'id' => 4,
                'name' => 'users.edit',
                'group' => 'users',
            ],
            [
                'id' => 5,
                'name' => 'users.delete',
                'group' => 'users',
            ],
            [
                'id' => 6,
                'name' => 'users.toggle_status',
                'group' => 'users',
            ],
            [
                'id' => 7,
                'name' => 'users.change_password',
                'group' => 'users',
            ],
            [
                'id' => 8,
                'name' => 'roles.view',
                'group' => 'roles',
            ],
            [
                'id' => 9,
                'name' => 'roles.create',
                'group' => 'roles',
            ],
            [
                'id' => 10,
                'name' => 'roles.edit',
                'group' => 'roles',
            ],
            [
                'id' => 11,
                'name' => 'roles.delete',
                'group' => 'roles',
            ],
            [
                'id' => 12,
                'name' => 'roles.assign',
                'group' => 'roles',
            ],
            [
                'id' => 13,
                'name' => 'wards.view',
                'group' => 'wards',
            ],
            [
                'id' => 14,
                'name' => 'wards.create',
                'group' => 'wards',
            ],
            [
                'id' => 15,
                'name' => 'wards.edit',
                'group' => 'wards',
            ],
            [
                'id' => 16,
                'name' => 'wards.delete',
                'group' => 'wards',
            ],
            [
                'id' => 17,
                'name' => 'department.view',
                'group' => 'department',
            ],
            [
                'id' => 18,
                'name' => 'department.create',
                'group' => 'department',
            ],
            [
                'id' => 19,
                'name' => 'department.edit',
                'group' => 'department',
            ],
            [
                'id' => 20,
                'name' => 'department.delete',
                'group' => 'department',
            ],
            [
                'id' => 21,
                'name' => 'home_department.view',
                'group' => 'home department',
            ],
            [
                'id' => 22,
                'name' => 'home_department.create',
                'group' => 'home department',
            ],
            [
                'id' => 23,
                'name' => 'home_department.edit',
                'group' => 'home department',
            ],
            [
                'id' => 24,
                'name' => 'home_department.delete',
                'group' => 'home department',
            ],
            [
                'id' => 25,
                'name' => 'member.view',
                'group' => 'member',
            ],
            [
                'id' => 26,
                'name' => 'member.create',
                'group' => 'member',
            ],
            [
                'id' => 27,
                'name' => 'member.edit',
                'group' => 'member',
            ],
            [
                'id' => 28,
                'name' => 'member.delete',
                'group' => 'member',
            ],
            [
                'id' => 29,
                'name' => 'meeting.view',
                'group' => 'meeting',
            ],
            [
                'id' => 30,
                'name' => 'meeting.create',
                'group' => 'meeting',
            ],
            [
                'id' => 31,
                'name' => 'meeting.edit',
                'group' => 'meeting',
            ],
            [
                'id' => 32,
                'name' => 'meeting.delete',
                'group' => 'meeting',
            ],
            [
                'id' => 33,
                'name' => 'goshwara.view',
                'group' => 'goshwara',
            ],
            [
                'id' => 34,
                'name' => 'goshwara.create',
                'group' => 'goshwara',
            ],
            [
                'id' => 35,
                'name' => 'goshwara.edit',
                'group' => 'goshwara',
            ],
            [
                'id' => 36,
                'name' => 'goshwara.delete',
                'group' => 'goshwara',
            ],
            [
                'id' => 37,
                'name' => 'agenda.view',
                'group' => 'agenda',
            ],
            [
                'id' => 38,
                'name' => 'agenda.create',
                'group' => 'agenda',
            ],
            [
                'id' => 39,
                'name' => 'agenda.edit',
                'group' => 'agenda',
            ],
            [
                'id' => 40,
                'name' => 'agenda.delete',
                'group' => 'agenda',
            ],
            [
                'id' => 41,
                'name' => 'schedule_meeting.view',
                'group' => 'schedule meeting',
            ],
            [
                'id' => 42,
                'name' => 'schedule_meeting.create',
                'group' => 'schedule meeting',
            ],
            [
                'id' => 43,
                'name' => 'schedule_meeting.edit',
                'group' => 'schedule meeting',
            ],
            [
                'id' => 44,
                'name' => 'schedule_meeting.delete',
                'group' => 'schedule meeting',
            ],
            [
                'id' => 45,
                'name' => 'question.view',
                'group' => 'question',
            ],
            [
                'id' => 46,
                'name' => 'question.create',
                'group' => 'question',
            ],
            [
                'id' => 47,
                'name' => 'question.edit',
                'group' => 'question',
            ],
            [
                'id' => 48,
                'name' => 'question.delete',
                'group' => 'question',
            ],
            [
                'id' => 49,
                'name' => 'goshwara.send',
                'group' => 'goshwara',
            ],
            [
                'id' => 50,
                'name' => 'question.response',
                'group' => 'question',
            ],
            [
                'id' => 51,
                'name' => 'attendance.view',
                'group' => 'attendance',
            ],
            [
                'id' => 52,
                'name' => 'attendance.create',
                'group' => 'attendance',
            ],
            [
                'id' => 53,
                'name' => 'attendance.edit',
                'group' => 'attendance',
            ],
            [
                'id' => 54,
                'name' => 'attendance.delete',
                'group' => 'attendance',
            ],
            [
                'id' => 55,
                'name' => 'reschedule_meeting.view',
                'group' => 'reschedule meeting',
            ],
            [
                'id' => 56,
                'name' => 'reschedule_meeting.create',
                'group' => 'reschedule meeting',
            ],
            [
                'id' => 57,
                'name' => 'reschedule_meeting.edit',
                'group' => 'reschedule meeting',
            ],
            [
                'id' => 58,
                'name' => 'reschedule_meeting.delete',
                'group' => 'reschedule meeting',
            ],
            [
                'id' => 59,
                'name' => 'suplimentry-agenda.view',
                'group' => 'suplimentry agenda',
            ],
            [
                'id' => 60,
                'name' => 'suplimentry-agenda.create',
                'group' => 'suplimentry agenda',
            ],
            [
                'id' => 61,
                'name' => 'suplimentry-agenda.edit',
                'group' => 'suplimentry agenda',
            ],
            [
                'id' => 62,
                'name' => 'suplimentry-agenda.delete',
                'group' => 'suplimentry agenda',
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                'id' => $permission['id']
            ], [
                'id' => $permission['id'],
                'name' => $permission['name'],
                'group' => $permission['group']
            ]);
        }
    }
}
