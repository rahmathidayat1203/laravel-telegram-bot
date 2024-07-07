<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'rahmat',
            'email' => 'rh63800@gmail.com',
            'password' => Hash::make('12341234'),
            'telegram_chat_id' => "1402276147"
        ]);
    }
}
