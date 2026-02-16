<?php

namespace Database\Seeders;

use App\Models\Bank\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bank::insert([
            ['name' => 'Mother Bank', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bank Asia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'One Bank', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'EBL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Islami Bank', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
