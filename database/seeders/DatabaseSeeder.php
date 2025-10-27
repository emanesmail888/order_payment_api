<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // Hash the password
            'points' => 0
        ]);

        Order::create(['user_id' => $user->id, 'total_price' => 50.00, 'status' => 'pending']);
        Order::create(['user_id' => $user->id, 'total_price' => 150.00, 'status' => 'pending']);
    }
}
