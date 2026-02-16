<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $divisions_en = [
        //     [
        //         'value' => 10,
        //         'title' => 'Barisal',
        //     ],
        //     [
        //         'value' => 20,
        //         'title' => 'Chattagram',
        //     ],
        //     [
        //         'value' => 30,
        //         'title' => 'Dhaka',
        //     ],
        //     [
        //         'value' => 40,
        //         'title' => 'Khulna',
        //     ],
        //     [
        //         'value' => 45,
        //         'title' => 'Mymensingh',
        //     ],
        //     [
        //         'value' => 50,
        //         'title' => 'Rajshahi',
        //     ],
        //     [
        //         'value' => 55,
        //         'title' => 'Rangpur',
        //     ],
        //     [
        //         'value' => 60,
        //         'title' => 'Sylhet',
        //     ],
        // ];

        // $transformedDivisions = array_map(function ($division) {
        //     return [
        //         'id' => $division['value'],
        //         'name' => $division['title'],
        //         'country_id' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }, $divisions_en);

        // Division::insert($transformedDivisions);

        $array = [
            ['name' => 'Rajshahi Division'],
            ['name' => 'Rangpur Division'],
            ['name' => 'Barisal Division'],
            ['name' => 'Chittagong Division'],
            ['name' => 'Dhaka Division'],
            ['name' => 'Khulna Division'],
            ['name' => 'Sylhet Division'],
        ];

        $insertData = [];
        $id = 1; // Initial ID value

        foreach ($array as $division) {
            $insertData[] = [
                'id' => $id,
                'name' => $division['name'], // Use the name from the array
                'country_id' => 1, // Assuming the country_id is constant
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $id++; // Increment ID for each division
        }

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Division::whereNot('id', 0)->delete();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Division::insert($insertData);

        // Division::insert(
        //     [
        //         ['id' => '1', 'name' => 'Chattagram', 'country_id' => '1', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '2', 'name' => 'Rajshahi', 'country_id' => '1', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '3', 'name' => 'Khulna', 'country_id' => '1', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '4', 'name' => 'Barisal', 'country_id' => '1', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '5', 'name' => 'Sylhet', 'country_id' => '1', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '6', 'name' => 'Dhaka', 'country_id' => '1', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '7', 'name' => 'Rangpur', 'country_id' => '1', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '8', 'name' => 'Mymensingh', 'country_id' => '1', 'created_at' => now(), 'updated_at' => now()],
        //     ]
        // );
    }
}
