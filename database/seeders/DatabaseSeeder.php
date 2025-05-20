<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 2 user utama
        User::factory()->create([
            'name' => 'hikmah',
            'email' => 'hikmah1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Nur Hikmah',
            'email' => '1hikmah@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ]);

        // Buat 101 user tambahan secara acak
        User::factory(101)->create();

        // Jangan panggil Category factory kalau memang tidak ada filenya
        
        // Buat 500 todo secara acak
        Todo::factory(500)->create();
    }
}


