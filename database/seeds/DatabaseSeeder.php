<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RootSeeder::class);
    }
}

class RootSeeder extends Seeder {
    public function run() {
//        User::create([
//            'username'	=>	'glitch',
//            'password'	=>	Hash::make('secretPassword1234'),
//            'full_name'	=>	'Flaviu Porutiu',
//            'privilege'	=>	3,
//            'email'		=>	'flaviu@societatea-hermes.ro'
//        ]);

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
