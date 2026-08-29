<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
{
    \App\Models\User::firstOrCreate(
        ['email' => 'admin@pharmacie.com'],
        [
            'name' => 'Aliou Baldé',
            'password' => bcrypt('password'), // Mot de passe : password
            'role' => 'gerant', // C'est le chef !
        ]
    );
}
}
