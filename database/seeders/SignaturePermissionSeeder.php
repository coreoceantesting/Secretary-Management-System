<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SignaturePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'signature.view', 'group' => 'signature'],
            ['name' => 'signature.create', 'group' => 'signature'],
            ['name' => 'signature.edit', 'group' => 'signature'],
            ['name' => 'signature.delete', 'group' => 'signature'],
        ];

        $permissionNames = [];
        foreach ($permissions as $permission) {
            $perm = Permission::firstOrCreate(
                ['name' => $permission['name']], 
                ['group' => $permission['group']]
            );
            $permissionNames[] = $permission['name'];
        }

        $superAdminRole = Role::where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo($permissionNames);
        }

        $this->command->info('Signature permissions created and assigned to Super Admin successfully!');
    }
}
