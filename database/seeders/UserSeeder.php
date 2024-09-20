<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Dalia Löff',
                'cpf' => preg_replace('/\D/', '', '548.272.990-72'),
                'email' => 'secretaria.geral@icm-sec.org.br',
                'phone' => preg_replace('/\D/', '', '51-99943.0432'),
                'birthdate' => '1965-12-21',
                'password' => Hash::make('senha123'),
            ],
            [
                'name' => 'Lia Lauxen',
                'cpf' => preg_replace('/\D/', '', '341.963.230-49'),
                'email' => 'secretaria@icm-sec.org.br',
                'phone' => preg_replace('/\D/', '', '51-99515.0860'),
                'birthdate' => '1956-05-05',
                'password' => Hash::make('senha123'),
            ],
            [
                'name' => 'Rejane Luft Nascimento',
                'cpf' => preg_replace('/\D/', '', '899.320.309-10'),
                'email' => 'apoio.geral@icm-sec.org.br',
                'phone' => preg_replace('/\D/', '', '51-99269.5289'),
                'birthdate' => '1975-03-23',
                'password' => Hash::make('senha123'),
            ],
            [
                'name' => 'Andrei De Lima Paz',
                'cpf' => preg_replace('/\D/', '', '860.440.600-04'),
                'email' => 'andrei.paz@irbm.com.br',
                'phone' => preg_replace('/\D/', '', '51-99588.5051'),
                'birthdate' => '1999-08-01',
                'password' => Hash::make('senha123'),
            ],
        ]);
    }
}
