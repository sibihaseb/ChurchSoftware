<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

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
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Retrieve or create the Superadmin role
        $roleSuperadmin = Role::firstOrCreate(['name' => 'Superadmin']);
        $roleDoner = Role::firstOrCreate(['name' => 'Doner']);
        // Define required permissions
        $permissions = ['User Management', 'Role Management'];

        foreach ($permissions as $permissionName) {
            $permission = Permission::firstOrCreate(['name' => $permissionName]);
            $roleSuperadmin->givePermissionTo($permission);
        }

        // Assign role to the user
        $superadmin->assignRole($roleSuperadmin);

        //dummy data

        DB::table('member_types')->insert([
            'name' => 'Family'
        ]);
        // DB::table('members')->insert([
        //     'member_type_id ' => "1",
        //     'first_name ' => 'Sibi',
        //     'last_name ' => 'Haseb',
        //     'address ' => 'xyz',
        //     'email ' => 'sasdasd@mail.com',
        //     'phone ' => "123123123",
        //     'check_in ' => Carbon::now(),
        //     'check_out ' => Carbon::now(),
        // ]);

        DB::table('products')->insert([
            'name' => 'Family'
        ]);
        DB::table('payment_methods')->insert([
            'name' => 'Family'
        ]);
        DB::table('deposite_accounts')->insert([
            'name' => 'Family'
        ]);
        DB::table('churches')->insert([
            'name' => 'Church'
        ]);
        DB::table('expenses')->insert([
            'name' => 'Tax',
            'amount' => 200,
            'church_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('budgets')->insert([
            'name' => 'Cleaning',
            'amount' => 100,
            'church_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->call([
            CountrySeeder::class,
            USStatesSeeder::class,
        ]);
    }
}
