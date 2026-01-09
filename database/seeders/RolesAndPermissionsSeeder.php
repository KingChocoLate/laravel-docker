<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create the Roles in the 'roles' table
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $staffRole = Role::create(['name' => 'staff']);

        // 2. Create the Admin User and link to the role
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->roles()->attach($adminRole->id);

        // 3. Create the Manager User
        $manager = User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
        ]);
        $manager->roles()->attach($managerRole->id);

        // 4. Create 2 Staff Users
        $staffUsers = User::factory(2)->create();
        foreach ($staffUsers as $user) {
            $user->roles()->attach($staffRole->id);
        }
    }
}

