<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Admin',
            'id_level'=>'1',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('12345678')
        ]);
        User::create([
            'name'=>'Operator',
            'id_level'=>'2',
            'email'=>'operator@gmail.com',
            'password'=>Hash::make('12345678')
        ]);
        User::create([
            'name'=>'Pemimpin',
            'id_level'=>'3',
            'email'=>'pemimpin@gmail.com',
            'password'=>Hash::make('12345678')
        ]);
    }
}