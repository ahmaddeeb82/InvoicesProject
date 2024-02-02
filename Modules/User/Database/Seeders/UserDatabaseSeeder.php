<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     private $permissions = [
        'export-pdf',
        'export-excel',
        'admin-permession',
    ];

    public function run(): void
    {
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role = Role::create(['name' => 'Admin']);
    }
}
