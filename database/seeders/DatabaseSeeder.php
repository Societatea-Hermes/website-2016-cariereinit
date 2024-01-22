<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username'	=>	'herman',
            'password'	=>	Hash::make('manageriCIT'),
            'full_name'	=>	'Cariere Admin',
            'privilege'	=>	3,
            'email'		=>	'contact@cariereinit.ro'
        ]);
        User::create([
            'username'	=>	'oana',
            'password'	=>	Hash::make('oanaoana'),
            'full_name'	=>	'Oana Sabadas',
            'privilege'	=>	3,
            'email'		=>	'oana.sabadas@societatea-hermes.ro'
        ]);
    }
}
