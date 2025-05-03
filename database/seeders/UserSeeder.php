<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



    DB::table('users')->insert([

       'name'=>'Eslam Gaber',
            'email'=>'e.gaber@ibdl.net',
            'password'=>Hash::make('12345678'),
            'phone_number'=>'01147174789'
    ]);
    }
}
