<?php

namespace Database\Seeders;

use App\Models\Transaction\TransactionCategory;
use Illuminate\Database\Seeder;

class TransactionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionCategory::insert([
            ['name' => 'Booking money', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Full payment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Advance payment', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
