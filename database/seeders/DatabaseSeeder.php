<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Superadmin user
        $superadmin = User::create([
            'email' => 'sibi@gmail.com',
            'name' => 'sibi',
            'password' => Hash::make('123456'),
            'role' => 'Superadmin',
            'account_type' => 'S',
        ]);

        // Retrieve or create the Superadmin role
        $roleSuperadmin = Role::firstOrCreate(['name' => 'Superadmin']);

        // Define required permissions
        $permissions = ['User Management', 'Role Management'];

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $roleSuperadmin->givePermissionTo($permission);
        }

        // Assign role to the user
        $superadmin->assignRole($roleSuperadmin);
    }
}
