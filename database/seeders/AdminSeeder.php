<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
{
    \App\Models\User::create([
        'name' => 'Aliou Baldé',
        'email' => 'admin@pharmacie.com',
        'password' => bcrypt('password'), // Mot de passe : password
        'role' => 'gerant', // C'est le chef !
    ]);
}
}
