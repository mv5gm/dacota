<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrador',
                'email' => 'admin@dacota.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
            ]
        );

        $admin->syncRoles(['admin']);
    }
}
