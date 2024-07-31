<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Administrator',
                'email' => 'admin@cbt',
                'email_verified_at' => '',
                'password' => Hash::make('qweqweasd'),
                'active' => '1',
                'remember_token' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        $role = [
            [
                'role_id' => '1',
                'user_id' => '1',
                'user_type' => 'App\Models\User',
            ]
        ];

        DB::table('users')->insert($user);
        DB::table('role_user')->insert($role);
    }
}
