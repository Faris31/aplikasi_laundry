<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Level::create([
            'level_name' => 'Admin'
        ]);
         Level::create([
            'level_name' => 'Operator'
        ]);
        Level::create([
            'level_name' => 'Pimpinan'
        ]);
    }
}
