<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];

        // Admin users
        $users[] = [
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $users[] = [
            'name' => 'System Administrator',
            'email' => 'system.admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Petugas users
        for ($i = 1; $i <= 5; $i++) {
            $users[] = [
                'name' => "Petugas {$i}",
                'email' => "petugas{$i}@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'petugas',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Pengunjung users (majority)
        for ($i = 1; $i <= 50; $i++) {
            $users[] = [
                'name' => "Pengunjung {$i}",
                'email' => "pengunjung{$i}@example.com",
                'email_verified_at' => rand(0, 1) ? now() : null, // Some verified, some not
                'password' => Hash::make('password123'),
                'role' => 'pengunjung',
                'remember_token' => rand(0, 1) ? \Illuminate\Support\Str::random(10) : null,
                'created_at' => Carbon::now()->subDays(rand(1, 365)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30)),
            ];
        }

        // Additional real-looking names for pengunjung
        $realNames = [
            'Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Lestari', 'Joko Widodo',
            'Maya Sari', 'Rizky Pratama', 'Linda Wati', 'Hendra Setiawan', 'Nina Astuti',
            'Fajar Ramadan', 'Citra Dewi', 'Agus Salim', 'Mega Puspita', 'Rudi Hartono',
            'Ani Wijaya', 'Eko Prasetyo', 'Ratna Sari', 'Dedi Kurniawan', 'Yuni Astuti',
            'Irfan Maulana', 'Sari Indah', 'Ade Supriyadi', 'Rina Marlina', 'Hari Purnomo',
            'Lia Amelia', 'Tono Sutrisno', 'Mila Kurnia', 'Wawan Setiawan', 'Dina Oktaviani'
        ];

        foreach ($realNames as $index => $name) {
            $users[] = [
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'pengunjung',
                'remember_token' => null,
                'created_at' => Carbon::now()->subDays(rand(1, 180)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30)),
            ];
        }

        // Insert all users
        DB::table('users')->insert($users);

        $this->command->info('Successfully seeded ' . count($users) . ' users!');
        $this->command->info('Admin credentials: admin@example.com / password123');
        $this->command->info('Petugas credentials: petugas1@example.com / password123');
        $this->command->info('Pengunjung credentials: pengunjung1@example.com / password123');
    }
}