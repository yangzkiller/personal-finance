<?php

namespace Database\Seeders\Testing;

use App\Models\Auth\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make(env('STAGING_LOCAL_PASSWORD'));

        $users = [
            [
                'name' => 'Usuário Padrão',
                'email' => 'user@admin.com',
                'password' => $password,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }   
    }
}