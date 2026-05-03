<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@dashboard.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->call(MataKuliahSeeder::class);
    }
}