<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Content::firstOrCreate(
            ['type' => 'terms'],
            [
                'title' => 'Terms & Conditions',
                'description' => '<p>Welcome to our Terms & Conditions. These are the rules and regulations for using our website.</p>
                                  <h3>1. Introduction</h3>
                                  <p>By accessing this website we assume you accept these terms and conditions...</p>',
            ]
        );

        Content::firstOrCreate(
            ['type' => 'cookies'],
            [
                'title' => 'Cookie Preferences',
                'description' => '<p>We use cookies to ensure you get the best experience on our website.</p>
                                  <h3>What are cookies?</h3>
                                  <p>Cookies are small text files that are used to store small pieces of information...</p>',
            ]
        );
    }
}
