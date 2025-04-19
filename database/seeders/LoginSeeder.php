<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('logins')->insert([
            [
                'name' => 'admin',
                'email' => 'softstorminfosys@gmail.com',
                'password' => Hash::make('123456')
            ],
        ]);
    }
}
