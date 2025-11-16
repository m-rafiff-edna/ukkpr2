<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RuangSeeder::class,
            UserSeeder::class
        ]);

        // Ensure a default admin exists (idempotent). This reads credentials from env so
        // platforms like Railway can set them as environment variables.
        $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
        $adminName = env('ADMIN_NAME', 'Super Admin');
        $adminPassword = env('ADMIN_PASSWORD', 'password123');

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $adminName,
                'email_verified_at' => now(),
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
            ]
        );
    }
}