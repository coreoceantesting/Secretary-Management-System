<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Party;
use App\Models\Ward;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'id' => 1,
                'name' => 'Information Technology',
                'initial' => 'IT',
                'is_home_department' => 0,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Account Department',
                'initial' => 'AD',
                'is_home_department' => 0,
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Finance Department',
                'initial' => 'FD',
                'is_home_department' => 0,
                'created_by' => 1,
                'updated_by' => 1,
            ]
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate([
                'id' => $department['id']
            ], [
                'id' => $department['id'],
                'name' => $department['name'],
                'initial' => $department['initial'],
                'is_home_department' => $department['is_home_department'],
                'created_by' => $department['created_by'],
                'updated_by' => $department['updated_by']
            ]);
        }


        $homeDepartments = [
            [
                'id' => 4,
                'name' => 'Secretary Department',
                'initial' => 'SD',
                'is_home_department' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]
        ];

        foreach ($homeDepartments as $homeDepartment) {
            Department::updateOrCreate([
                'id' => $homeDepartment['id']
            ], [
                'id' => $homeDepartment['id'],
                'name' => $homeDepartment['name'],
                'initial' => $homeDepartment['initial'],
                'is_home_department' => $homeDepartment['is_home_department'],
                'created_by' => $homeDepartment['created_by'],
                'updated_by' => $homeDepartment['updated_by']
            ]);
        }




        $parties = [
            [
                'id' => 1,
                'name' => 'भारतीय जनता पार्टी (BJP)',
            ],
            [
                'id' => 2,
                'name' => 'आम आदमी पार्टी (AAP)',
            ],
            [
                'id' => 3,
                'name' => 'राष्ट्रीय कॉंग्रेस पार्टी (NCP)',
            ]
        ];

        foreach ($parties as $party) {
            Party::updateOrCreate([
                'id' => $party['id']
            ], [
                'id' => $party['id'],
                'name' => $party['name']
            ]);
        }



        $wards = [
            [
                'id' => 1,
                'name' => 'Ward 1',
                'initial' => 'W1',
                'created_by' => '1'
            ],
            [
                'id' => 2,
                'name' => 'Ward 2',
                'initial' => 'W2',
                'created_by' => '1'
            ],
            [
                'id' => 3,
                'name' => 'Ward 3',
                'initial' => 'W3',
                'created_by' => '1'
            ],
            [
                'id' => 4,
                'name' => 'Ward 4',
                'initial' => 'W4',
                'created_by' => '1'
            ]
        ];

        foreach ($wards as $ward) {
            Ward::updateOrCreate([
                'id' => $ward['id']
            ], [
                'id' => $ward['id'],
                'name' => $ward['name'],
                'initial' => $ward['initial'],
                'created_by' => $ward['created_by']
            ]);
        }
    }
}
