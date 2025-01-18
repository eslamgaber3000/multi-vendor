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



    // DB::table('users')->insert([

    //    'name'=>'system Admin',
    //         'email'=>'eslam556547@gmail.com',
    //         'password'=>Hash::make('password'),
    //         'phone_number'=>'01016403403'
    // ]);
    }
}
