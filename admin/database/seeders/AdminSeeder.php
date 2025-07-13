<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'firstname' => 'Sosethika',
                'lastname' => 'Kou',
                'email' => 'sosethika@gmail.com',
                'password' => Hash::make('12345678'),
                'status' => '1',
                'photo' => null,
            ],
            [
                'firstname' => 'Kunrothny',
                'lastname' => 'Leyhong',
                'email' => 'kunrothny@gmail.com',
                'password' => Hash::make('12345678'),
                'status' => '1',
                'photo' => null,
            ],
            [
                'firstname' => 'Seap',
                'lastname' => 'Lun',
                'email' => 'seaplun@gmail.com',
                'password' => Hash::make('12345678'),
                'status' => '1',
                'photo' => null,
            ],
            [
                'firstname' => 'Sunzana',
                'lastname' => 'Sreng',
                'email' => 'sunzana@gmail.com',
                'password' => Hash::make('12345678'),
                'status' => '1',
                'photo' => null,
            ],
            [
                'firstname' => 'Sokha',
                'lastname' => 'Seng',
                'email' => 'sokha@gmail.com',
                'password' => Hash::make('12345678'),
                'status' => '1',
                'photo' => null,
            ],
        ];

        foreach ($admins as $admin) {
            Admin::updateOrCreate(
                ['email' => $admin['email']], // Search by email
                $admin                         // Update or insert the rest
            );
        }
    }
}