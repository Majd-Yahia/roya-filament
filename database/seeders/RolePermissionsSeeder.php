<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve roles and permissions
        $adminRole = Role::where('name', 'admin')->first();
        $permissions = Permission::select('id', 'name')->get();


        // Sync permissions to roles
        $adminRole->permissions()->sync($permissions->pluck('id'));


        // For testing only view only role
        $viewerRole = Role::where('name', 'viewer')->first();
        $viewerPermissions = $permissions->whereIn('name', ['roles.index', 'roles.edit'])->pluck('id');
        $viewerRole->permissions()->sync($viewerPermissions);


        // For testing only Moderate role
        $modrateRole = Role::where('name', 'role-moderator')->first();
        $modratepermission = $permissions->whereIn('name', ['roles.index', 'roles.delete']);
        $modrateRole->permissions()->sync($modratepermission->pluck('id'));
    }
}
