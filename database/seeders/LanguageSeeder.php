<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $languages = [
            ['name' => 'English', 'code' => 'en', 'status' => true],
            ['name' => 'Bangla', 'code' => 'bn', 'status' => true],
            ['name' => 'Arabic', 'code' => 'ar', 'status' => true],
        ];

        foreach ($languages as $language) {
            \App\Models\Language::create($language);
        }
    }
}
