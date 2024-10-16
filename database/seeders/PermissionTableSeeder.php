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
            [
                'id' => 76,
                'name' => 'party.view',
                'group' => 'party',
            ],
            [
                'id' => 77,
                'name' => 'party.create',
                'group' => 'party',
            ],
            [
                'id' => 78,
                'name' => 'party.edit',
                'group' => 'party',
            ],
            [
                'id' => 79,
                'name' => 'party.delete',
                'group' => 'party',
            ],
            [
                'id' => 80,
                'name' => 'agenda.receipt',
                'group' => 'agenda',
            ],
            [
                'id' => 81,
                'name' => 'laxvadi.view',
                'group' => 'laxvadi',
            ],
            [
                'id' => 82,
                'name' => 'laxvadi.create',
                'group' => 'laxvadi',
            ],
            [
                'id' => 83,
                'name' => 'laxvadi.edit',
                'group' => 'laxvadi',
            ],
            [
                'id' => 84,
                'name' => 'laxvadi.delete',
                'group' => 'laxvadi',
            ],
            [
                'id' => 85,
                'name' => 'laxvadi.response',
                'group' => 'laxvadi',
            ],
            [
                'id' => 86,
                'name' => 'prastav-suchana.view',
                'group' => 'prastav-suchana',
            ],
            [
                'id' => 87,
                'name' => 'prastav-suchana.create',
                'group' => 'prastav-suchana',
            ],
            [
                'id' => 88,
                'name' => 'prastav-suchana.edit',
                'group' => 'prastav-suchana',
            ],
            [
                'id' => 89,
                'name' => 'prastav-suchana.delete',
                'group' => 'prastav-suchana',
            ],
            [
                'id' => 90,
                'name' => 'prastav-suchana.response',
                'group' => 'prastav-suchana',
            ],
            [
                'id' => 91,
                'name' => 'reservation-category.index',
                'group' => 'reservation-category',
            ],
            [
                'id' => 92,
                'name' => 'reservation-category.create',
                'group' => 'reservation-category',
            ],
            [
                'id' => 93,
                'name' => 'reservation-category.edit',
                'group' => 'reservation-category',
            ],
            [
                'id' => 94,
                'name' => 'reservation-category.delete',
                'group' => 'reservation-category',
            ],
            [
                'id' => 95,
                'name' => 'election-meeting.index',
                'group' => 'election-meeting',
            ],
            [
                'id' => 96,
                'name' => 'election-meeting.create',
                'group' => 'election-meeting',
            ],
            [
                'id' => 97,
                'name' => 'election-meeting.edit',
                'group' => 'election-meeting',
            ],
            [
                'id' => 98,
                'name' => 'election-meeting.delete',
                'group' => 'election-meeting',
            ],
            [
                'id' => 99,
                'name' => 'election-agenda.index',
                'group' => 'election-agenda',
            ],
            [
                'id' => 100,
                'name' => 'election-agenda.create',
                'group' => 'election-agenda',
            ],
            [
                'id' => 101,
                'name' => 'election-agenda.edit',
                'group' => 'election-agenda',
            ],
            [
                'id' => 102,
                'name' => 'election-agenda.delete',
                'group' => 'election-agenda',
            ],
            [
                'id' => 103,
                'name' => 'election-schedule-meeting.index',
                'group' => 'election-schedule-meeting',
            ],
            [
                'id' => 104,
                'name' => 'election-schedule-meeting.create',
                'group' => 'election-schedule-meeting',
            ],
            [
                'id' => 105,
                'name' => 'election-schedule-meeting.cancel',
                'group' => 'election-schedule-meeting',
            ],
            [
                'id' => 106,
                'name' => 'election-schedule-meeting.show',
                'group' => 'election-schedule-meeting',
            ],
            [
                'id' => 107,
                'name' => 'election-reschedule-meeting.index',
                'group' => 'election-reschedule-meeting',
            ],
            [
                'id' => 108,
                'name' => 'election-reschedule-meeting.create',
                'group' => 'election-reschedule-meeting',
            ],
            [
                'id' => 109,
                'name' => 'election-reschedule-meeting.cancel',
                'group' => 'election-reschedule-meeting',
            ],
            [
                'id' => 110,
                'name' => 'election-reschedule-meeting.show',
                'group' => 'election-reschedule-meeting',
            ],
            [
                'id' => 111,
                'name' => 'election-proceeding-record.view',
                'group' => 'election-proceeding-record',
            ],
            [
                'id' => 112,
                'name' => 'election-proceeding-record.create',
                'group' => 'election-proceeding-record',
            ],
            [
                'id' => 113,
                'name' => 'election-proceeding-record.show',
                'group' => 'election-proceeding-record',
            ],
            [
                'id' => 114,
                'name' => 'election-proceeding-record.pdf',
                'group' => 'election-proceeding-record',
            ],
            [
                'id' => 115,
                'name' => 'election-document-history.index',
                'group' => 'election-document-history',
            ],
            [
                'id' => 116,
                'name' => 'election-document-history.create',
                'group' => 'election-document-history',
            ],
            [
                'id' => 117,
                'name' => 'election-document-history.edit',
                'group' => 'election-document-history',
            ],
            [
                'id' => 118,
                'name' => 'election-document-history.delete',
                'group' => 'election-document-history',
            ],
            [
                'id' => 119,
                'name' => 'report.election-meeting',
                'group' => 'report',
            ],
            [
                'id' => 120,
                'name' => 'report.election-attendance',
                'group' => 'report',
            ],
            [
                'id' => 121,
                'name' => 'election-suplimentry-agenda.index',
                'group' => 'election-suplimentry-agenda',
            ],
            [
                'id' => 122,
                'name' => 'election-suplimentry-agenda.create',
                'group' => 'election-suplimentry-agenda',
            ],
            [
                'id' => 123,
                'name' => 'election-suplimentry-agenda.edit',
                'group' => 'election-suplimentry-agenda',
            ],
            [
                'id' => 124,
                'name' => 'election-suplimentry-agenda.delete',
                'group' => 'election-suplimentry-agenda',
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
