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
                'group' => 'home_department',
            ],
            [
                'id' => 22,
                'name' => 'home_department.create',
                'group' => 'home_department',
            ],
            [
                'id' => 23,
                'name' => 'home_department.edit',
                'group' => 'home_department',
            ],
            [
                'id' => 24,
                'name' => 'home_department.delete',
                'group' => 'home_department',
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
