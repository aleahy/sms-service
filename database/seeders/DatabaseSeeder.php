<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(50)->create();
         User::factory()->create([
             'name' => 'Alex Leahy',
             'email' => 'alex.leahy@telmy.co',
             'password' => Hash::make('password'),
         ]);
    }
}
