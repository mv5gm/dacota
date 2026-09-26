<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $editor = User::updateOrCreate(
            ['username' => 'editor'],
            [
                'name' => 'Editor Demo',
                'email' => 'editor@dacota.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
            ]
        );

        $editor->syncRoles(['editor']);

        $basic = User::updateOrCreate(
            ['username' => 'demo'],
            [
                'name' => 'Usuario Demo',
                'email' => 'demo@dacota.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
            ]
        );

        $basic->syncRoles(['user']);
    }
}
