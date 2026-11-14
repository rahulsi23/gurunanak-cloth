<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'rp524917@gmail.com'],
            [
                'name' => 'Master Administrator',
                'password' => Hash::make('11111111'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
