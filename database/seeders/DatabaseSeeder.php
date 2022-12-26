<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        \App\Models\App::create([
            'APP_IMAGE' => 'URL/URL/URL/URL',
        ]);

        \App\Models\User::create([
            'name' => 'test',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin@admin.com'),
        ]);
    }
}
