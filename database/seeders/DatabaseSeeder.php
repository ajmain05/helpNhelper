<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            // CountrySeeder::class,
            // UpazilaSeeder::class,
            // DistrictSeeder::class,
            // DivisionSeeder::class,
            // UserSeeder::class,
            // BankSeeder::class,
            // BankAccountSeeder::class,
            // InvoiceStatusSeeder::class,
            // TransactionModeSeeder::class,
            // TransactionCategorySeeder::class,
            // FaqSeeder::class,
            // ContentSeeder::class
        ]);

        // Content::create([
        //     'type' => 'hero-section',
        //     'title' => 'Raise More: Ascend to Greater Heights',
        //     'description' => 'Lorem ipsum dolor sit amet consectetur. Dictumst elementum libero velit pellentesque enim sodales ultricies. Ut duis integer luctus amet elementum re.',
        // ]);

        // Content::create([
        //     'type' => 'about',
        //     'title' => 'Lorem ipsum dolor sit amet consectetur. Dictumst elementum libero velit pellentesque enim sodales ultricies. Ut duis integer luctus amet elementum re.',
        //     'description' => 'helpNhelper is an innovative project of Alhaj Shamsul Hoque Foundation (ASHF). It is a 100% secure and reliable platform for both the help seekers and the donors. ASHF is a non-profit charity and government approved NGO (Reg No: 3201, RJSC Reg No: CHS-620/2018, DNC Reg: 01/2021-22) in Bangladesh. It has received the Special Consultative Status to the United Nations Economic and Social Council (ECOSOC).',
        // ]);
    }
}
