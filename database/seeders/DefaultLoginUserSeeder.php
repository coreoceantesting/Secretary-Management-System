<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class DefaultLoginUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Super Admin Seeder ##
        $superAdminRole = Role::updateOrCreate(['name' => 'Super Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        $superAdminRole->syncPermissions($permissions);

        $user = User::updateOrCreate([
            'email' => 'superadmin@gmail.com'
        ], [
            'fname' => 'Super Admin',
            'lname' => 'Super Admin',
            'mname' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'username' => 'superadmin',
            'contact' => '9999999991',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole([$superAdminRole->id]);



        // Admin Seeder ##
        $adminRole = Role::updateOrCreate(['name' => 'Admin']);
        // $permissions = Permission::pluck('id', 'id')->all();
        // $adminRole->syncPermissions($permissions);

        $user = User::updateOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'fname' => 'Admin',
            'lname' => 'Admin',
            'mname' => 'Admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'contact' => '9999999992',
            'password' => Hash::make('12345678')
        ]);
        $user->assignRole([$adminRole->id]);


        Role::updateOrCreate(['name' => 'DMC']);
        Role::updateOrCreate(['name' => 'Mayor']);
        Role::updateOrCreate(['name' => 'Department']);
        Role::updateOrCreate(['name' => 'Home Department']);
        Role::updateOrCreate(['name' => 'Clerk']);
    }
}
