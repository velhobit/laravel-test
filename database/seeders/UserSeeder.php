<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::table('users')->truncate();

        User::create([
            'name' => 'Root',
            'email' => 'rodrigo@velhobit.com.br',
            'role' => 'root',
            'email_verified_at' => now(),
            'password' => bcrypt('root'),
            'phone' => '11999990000',
            'cpf' => '00000000191',
            'rg' => '123456789',
            'address' => 'Rua Admin, 1000',
            'city' => 'São Paulo',
            'state' => 'SP',
            'birthdate' => '1980-01-01',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
