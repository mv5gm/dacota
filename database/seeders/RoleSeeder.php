<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
            $this->flushCache();
        }

        $admin = Role::findOrCreate('admin');
        $admin->syncPermissions($permissions);
        $this->flushCache();

        $editor = Role::findOrCreate('editor');
        $editor->syncPermissions(['users.view', 'roles.view']);
        $this->flushCache();

        Role::findOrCreate('user');
        $this->flushCache();
    }

    private function flushCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
