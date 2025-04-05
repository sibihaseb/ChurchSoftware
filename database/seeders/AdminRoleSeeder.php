<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);

        $permissions = [
            'User Management',
            'Role Management',
            'Church Management',
            'Language Management',
            'Country Management',
            'State Management',
            'Account Management',
            'Deposit Account Management',
            'Payment Method Management',
            'Product Management',
            'Donor Management',
            'Department Management',
            'Expense Management',
            'Budget Management',
            'Donation Management',
        ];

        $roleAdmin->givePermissionTo($permissions);
    }
}
