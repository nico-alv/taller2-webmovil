<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Ochietto',
            'last_name' => '',
            'dni' => '12345678-1',
            'email' => '',
            'password' => bcrypt('Jaqamain3pals'),
            'role' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'Nicolas',
            'last_name' => 'Alvarez',
            'dni' => '20936459-K',
            'email' => 'nicolas.alvarez02@alumnos.ucn.cl',
            'password' => bcrypt('contra123'),
            'role' => 0
        ]);
        DB::table('users')->insert([
            'name' => 'Isabella',
            'last_name' => 'Gonzalez',
            'dni' => '34567890-2',
            'email' => 'isabella.gonzalez@example.com',
            'password' => bcrypt('securepass123'),
            'points' => 100,
            'role' => 0
        ]);

        DB::table('users')->insert([
            'name' => 'Peter',
            'last_name' => 'Hedron',
            'dni' => '45678901-3',
            'email' => 'peter.hedron@example.com',
            'password' => bcrypt('password456'),
            'points' => 434,
            'role' => 0
        ]);
    }
}
