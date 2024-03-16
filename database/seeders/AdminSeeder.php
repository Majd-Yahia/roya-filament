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
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $user->email_verified_at = now();
        $user->is_admin = true;
        $user->save();

        // Retrieve roles and permissions
        $adminRole = Role::where('name', 'admin')->first();

        // Assign roles to user
        $user->roles()->sync($adminRole);


        // ========================================================================
        // For testing purposes only. ViewerOnly User
        // ========================================================================
        $viewerOnlyUser = User::create([
            'name' => 'Testing Viewer',
            'email' => 'viewer@admin.com',
            'password' => bcrypt('password'),
        ]);
        $viewerOnlyUser->email_verified_at = now();
        $viewerOnlyUser->is_admin = true;
        $viewerOnlyUser->save();

        // Retrieve roles and permissions
        $viewerRole = Role::where('name', 'viewer')->first();

        // Assign roles to user
        $viewerOnlyUser->roles()->sync($viewerRole);


        // ========================================================================
        // For testing purposes only. Viewer Delete Role User
        // ========================================================================
        $moderateUser = User::create([
            'name' => 'Testing Viewer',
            'email' => 'role-moderator@admin.com',
            'password' => bcrypt('password'),
        ]);
        $moderateUser->email_verified_at = now();
        $moderateUser->is_admin = true;
        $moderateUser->save();

        // Retrieve roles and permissions
        $moderatorRole = Role::where('name', 'role-moderator')->first();

        // Assign roles to user
        $moderateUser->roles()->sync($moderatorRole);
    }
}
