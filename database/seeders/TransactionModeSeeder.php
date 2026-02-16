<?php

namespace Database\Seeders;

use App\Models\Transaction\TransactionMode;
use Illuminate\Database\Seeder;

class TransactionModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionMode::insert([
            ['name' => 'NPSB', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'BEFTN', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RTGS', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cash', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Others', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
