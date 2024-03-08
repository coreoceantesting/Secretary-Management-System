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
                'name' => 'department.view',
                'group' => 'department',
            ],
            [
                'id' => 3,
                'name' => 'department.create',
                'group' => 'department',
            ],
            [
                'id' => 4,
                'name' => 'department.edit',
                'group' => 'department',
            ],
            [
                'id' => 5,
                'name' => 'department.delete',
                'group' => 'department',
            ],
            [
                'id' => 6,
                'name' => 'home_department.view',
                'group' => 'home department',
            ],
            [
                'id' => 7,
                'name' => 'home_department.create',
                'group' => 'home department',
            ],
            [
                'id' => 8,
                'name' => 'home_department.edit',
                'group' => 'home department',
            ],
            [
                'id' => 9,
                'name' => 'home_department.delete',
                'group' => 'home department',
            ],
            [
                'id' => 10,
                'name' => 'wards.view',
                'group' => 'wards',
            ],
            [
                'id' => 11,
                'name' => 'wards.create',
                'group' => 'wards',
            ],
            [
                'id' => 12,
                'name' => 'wards.edit',
                'group' => 'wards',
            ],
            [
                'id' => 13,
                'name' => 'wards.delete',
                'group' => 'wards',
            ],
            [
                'id' => 14,
                'name' => 'member.view',
                'group' => 'member',
            ],
            [
                'id' => 15,
                'name' => 'member.create',
                'group' => 'member',
            ],
            [
                'id' => 16,
                'name' => 'member.edit',
                'group' => 'member',
            ],
            [
                'id' => 17,
                'name' => 'member.delete',
                'group' => 'member',
            ],
            [
                'id' => 18,
                'name' => 'meeting.view',
                'group' => 'meeting',
            ],
            [
                'id' => 19,
                'name' => 'meeting.create',
                'group' => 'meeting',
            ],
            [
                'id' => 20,
                'name' => 'meeting.edit',
                'group' => 'meeting',
            ],
            [
                'id' => 21,
                'name' => 'meeting.delete',
                'group' => 'meeting',
            ],
            [
                'id' => 22,
                'name' => 'users.view',
                'group' => 'users',
            ],
            [
                'id' => 23,
                'name' => 'users.create',
                'group' => 'users',
            ],
            [
                'id' => 24,
                'name' => 'users.edit',
                'group' => 'users',
            ],
            [
                'id' => 25,
                'name' => 'users.delete',
                'group' => 'users',
            ],
            [
                'id' => 26,
                'name' => 'users.toggle_status',
                'group' => 'users',
            ],
            [
                'id' => 27,
                'name' => 'users.change_password',
                'group' => 'users',
            ],
            [
                'id' => 28,
                'name' => 'roles.view',
                'group' => 'roles',
            ],
            [
                'id' => 29,
                'name' => 'roles.create',
                'group' => 'roles',
            ],
            [
                'id' => 30,
                'name' => 'roles.edit',
                'group' => 'roles',
            ],
            [
                'id' => 31,
                'name' => 'roles.delete',
                'group' => 'roles',
            ],
            [
                'id' => 32,
                'name' => 'roles.assign',
                'group' => 'roles',
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
                'id' => 47,
                'name' => 'goshwara.send',
                'group' => 'goshwara',
            ],
            [
                'id' => 48,
                'name' => 'agenda.view',
                'group' => 'agenda',
            ],
            [
                'id' => 49,
                'name' => 'agenda.create',
                'group' => 'agenda',
            ],
            [
                'id' => 50,
                'name' => 'agenda.edit',
                'group' => 'agenda',
            ],
            [
                'id' => 51,
                'name' => 'agenda.delete',
                'group' => 'agenda',
            ],
            [
                'id' => 52,
                'name' => 'suplimentry-agenda.view',
                'group' => 'suplimentry agenda',
            ],
            [
                'id' => 53,
                'name' => 'suplimentry-agenda.create',
                'group' => 'suplimentry agenda',
            ],
            [
                'id' => 54,
                'name' => 'suplimentry-agenda.edit',
                'group' => 'suplimentry agenda',
            ],
            [
                'id' => 55,
                'name' => 'suplimentry-agenda.delete',
                'group' => 'suplimentry agenda',
            ],
            [
                'id' => 56,
                'name' => 'schedule_meeting.view',
                'group' => 'schedule meeting',
            ],
            [
                'id' => 57,
                'name' => 'schedule_meeting.create',
                'group' => 'schedule meeting',
            ],
            [
                'id' => 58,
                'name' => 'schedule_meeting.show',
                'group' => 'schedule meeting',
            ],
            [
                'id' => 59,
                'name' => 'schedule_meeting.cancel',
                'group' => 'schedule meeting',
            ],
            [
                'id' => 60,
                'name' => 'reschedule_meeting.view',
                'group' => 'reschedule meeting',
            ],
            [
                'id' => 61,
                'name' => 'reschedule_meeting.create',
                'group' => 'reschedule meeting',
            ],
            [
                'id' => 62,
                'name' => 'reschedule_meeting.show',
                'group' => 'reschedule meeting',
            ],
            [
                'id' => 63,
                'name' => 'reschedule_meeting.cancel',
                'group' => 'reschedule meeting',
            ],
            [
                'id' => 64,
                'name' => 'question.view',
                'group' => 'question',
            ],
            [
                'id' => 65,
                'name' => 'question.create',
                'group' => 'question',
            ],
            [
                'id' => 66,
                'name' => 'question.edit',
                'group' => 'question',
            ],
            [
                'id' => 67,
                'name' => 'question.delete',
                'group' => 'question',
            ],
            [
                'id' => 68,
                'name' => 'question.response',
                'group' => 'question',
            ],
            [
                'id' => 69,
                'name' => 'attendance.view',
                'group' => 'attendance',
            ],
            [
                'id' => 70,
                'name' => 'attendance.mark',
                'group' => 'attendance',
            ],
            [
                'id' => 71,
                'name' => 'proceeding-record.view',
                'group' => 'proceeding-record',
            ],
            [
                'id' => 72,
                'name' => 'proceeding-record.create',
                'group' => 'proceeding-record',
            ],
            [
                'id' => 73,
                'name' => 'proceeding-record.show',
                'group' => 'proceeding-record',
            ],
            [
                'id' => 74,
                'name' => 'tharav.view',
                'group' => 'tharav',
            ],
            [
                'id' => 75,
                'name' => 'tharav.create',
                'group' => 'tharav',
            ],
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
