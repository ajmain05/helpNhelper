<?php

namespace Database\Seeders;

use App\Models\Invoice\InvoiceStatus;
use Illuminate\Database\Seeder;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InvoiceStatus::insert([
            ['name' => 'Credited', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bounced', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Due', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Receipt By Office', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
