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
    }
}
