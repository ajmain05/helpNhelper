<?php

namespace Database\Seeders;

use App\Models\Bank\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankAccount::insert([
            ['bank_id' => 1, 'branch_name' => 'Mother Branch', 'account_number' => 'Mother Account', 'opening_balance' => 1234, 'current_balance' => 1234, 'created_at' => now(), 'updated_at' => now()],
            ['bank_id' => 2, 'branch_name' => 'Anderkilla', 'account_number' => 'ABC-123123', 'opening_balance' => 1234, 'current_balance' => 1234, 'created_at' => now(), 'updated_at' => now()],
            ['bank_id' => 2, 'branch_name' => 'Anderkilla', 'account_number' => 'ABC-123124', 'opening_balance' => 1234, 'current_balance' => 1234, 'created_at' => now(), 'updated_at' => now()],
            ['bank_id' => 2, 'branch_name' => 'Anderkilla', 'account_number' => 'ABC-123125', 'opening_balance' => 1234, 'current_balance' => 1234, 'created_at' => now(), 'updated_at' => now()],
            ['bank_id' => 3, 'branch_name' => 'Anderkilla', 'account_number' => 'ABC-123126', 'opening_balance' => 1234, 'current_balance' => 1234, 'created_at' => now(), 'updated_at' => now()],
            ['bank_id' => 4, 'branch_name' => 'Anderkilla', 'account_number' => 'ABC-123127', 'opening_balance' => 1234, 'current_balance' => 1234, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
