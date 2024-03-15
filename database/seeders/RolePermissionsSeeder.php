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
       $permissions = Permission::select('id')->get()->pluck('id');

       // Sync permissions to roles
       $adminRole->permissions()->sync($permissions);

       $viewerRole = Role::where('name', 'viewer')->first();
       $viewerpermission = Permission::where('name', 'roles.index')->first();

       $viewerRole->permissions()->sync([$viewerpermission->id]);
    }
}
