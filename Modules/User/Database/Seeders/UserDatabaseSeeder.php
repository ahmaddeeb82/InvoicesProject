<?php

namespace Modules\User\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Modules\User\App\Models\User as ModelsUser;
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

        $user = ModelsUser::create([
            'name' => 'Ashraf Sroujy',
            'username' => 'ashraf',
            'password' => Crypt::encryptString('123456'),
            'role' => 'admin',
        ]);

        $role = Role::create(['name' => 'Admin']);

        Role::create(['name' => 'User']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
