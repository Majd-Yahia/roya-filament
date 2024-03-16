<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{

    /**
     * rolesPermission
     *
     * @var array
     */
    private $rolesPermission = [
        ['name' => 'roles.index'],
        ['name' => 'roles.create'],
        ['name' => 'roles.edit'],
        ['name' => 'roles.delete']
    ];


    /**
     * usersPermission
     *
     * @var array
     */
    private $usersPermission = [
        ['name' => 'users.index'],
        ['name' => 'users.create'],
        ['name' => 'users.edit'],
        ['name' => 'users.delete']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert($this->rolesPermission);
        Permission::insert($this->usersPermission);
    }
}
