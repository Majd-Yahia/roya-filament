<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed a user
        $user = User::create([
            'name' => 'Testing Admin',
            'email' => 'test@admin.com',
            'password' => bcrypt('password'),
        ]);

        // Retrieve roles and permissions
        $adminRole = Role::where('name', 'admin')->first();

        // Assign roles to user
        $user->roles()->sync($adminRole);


        // ========================================================================
        // For testing purposes only.
        // ========================================================================
        $viewerUser = User::create([
            'name' => 'Testing Viewer',
            'email' => 'viewer@admin.com',
            'password' => bcrypt('password'),
        ]);

        // Retrieve roles and permissions
        $viewerRole = Role::where('name', 'viewer')->first();

        // Assign roles to user
        $viewerUser->roles()->sync($viewerRole);
    }
}
