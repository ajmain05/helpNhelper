<?php

namespace Database\Seeders;

use App\Models\District;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $values = json_decode('{
        //     "10": [
        //         {
        //         "value": 4,
        //         "title": "Barguna"
        //         },
        //         {
        //         "value": 6,
        //         "title": "Barisal"
        //         },
        //         {
        //         "value": 9,
        //         "title": "Bhola"
        //         },
        //         {
        //         "value": 42,
        //         "title": "Jhalakathi"
        //         },
        //         {
        //         "value": 78,
        //         "title": "Patuakhali"
        //         },
        //         {
        //         "value": 79,
        //         "title": "Pirojpur"
        //         }
        //     ],
        //     "20": [
        //         {
        //         "value": 3,
        //         "title": "Bandarban"
        //         },
        //         {
        //         "value": 12,
        //         "title": "Brahmanbaria"
        //         },
        //         {
        //         "value": 13,
        //         "title": "Chandpur"
        //         },
        //         {
        //         "value": 15,
        //         "title": "Chattogram"
        //         },
        //         {
        //         "value": 19,
        //         "title": "Comilla"
        //         },
        //         {
        //         "value": 22,
        //         "title": "Coxsbazar"
        //         },
        //         {
        //         "value": 30,
        //         "title": "Feni"
        //         },
        //         {
        //         "value": 46,
        //         "title": "Khagrachhari"
        //         },
        //         {
        //         "value": 51,
        //         "title": "Lakshmipur"
        //         },
        //         {
        //         "value": 75,
        //         "title": "Noakhali"
        //         },
        //         {
        //         "value": 84,
        //         "title": "Rangamati"
        //         }
        //     ],
        //     "30": [
        //         {
        //         "value": 26,
        //         "title": "Dhaka"
        //         },
        //         {
        //         "value": 29,
        //         "title": "Faridpur"
        //         },
        //         {
        //         "value": 33,
        //         "title": "Gazipur"
        //         },
        //         {
        //         "value": 35,
        //         "title": "Gopalganj"
        //         },
        //         {
        //         "value": 48,
        //         "title": "Kishoreganj"
        //         },
        //         {
        //         "value": 54,
        //         "title": "Madaripur"
        //         },
        //         {
        //         "value": 56,
        //         "title": "Manikganj"
        //         },
        //         {
        //         "value": 59,
        //         "title": "Munshiganj"
        //         },
        //         {
        //         "value": 67,
        //         "title": "Narayanganj"
        //         },
        //         {
        //         "value": 68,
        //         "title": "Narsingdi"
        //         },
        //         {
        //         "value": 82,
        //         "title": "Rajbari"
        //         },
        //         {
        //         "value": 86,
        //         "title": "Shariatpur"
        //         },
        //         {
        //         "value": 93,
        //         "title": "Tangail"
        //         }
        //     ],
        //     "40": [
        //         {
        //         "value": 1,
        //         "title": "Bagerhat"
        //         },
        //         {
        //         "value": 18,
        //         "title": "Chuadanga"
        //         },
        //         {
        //         "value": 41,
        //         "title": "Jashore"
        //         },
        //         {
        //         "value": 44,
        //         "title": "Jhenaidah"
        //         },
        //         {
        //         "value": 47,
        //         "title": "Khulna"
        //         },
        //         {
        //         "value": 50,
        //         "title": "Kushtia"
        //         },
        //         {
        //         "value": 55,
        //         "title": "Magura"
        //         },
        //         {
        //         "value": 57,
        //         "title": "Meherpur"
        //         },
        //         {
        //         "value": 65,
        //         "title": "Narail"
        //         },
        //         {
        //         "value": 87,
        //         "title": "Satkhira"
        //         }
        //     ],
        //     "45": [
        //         {
        //         "value": 39,
        //         "title": "Jamalpur"
        //         },
        //         {
        //         "value": 61,
        //         "title": "Mymensingh"
        //         },
        //         {
        //         "value": 72,
        //         "title": "Netrokona"
        //         },
        //         {
        //         "value": 89,
        //         "title": "Sherpur"
        //         }
        //     ],
        //     "50": [
        //         {
        //         "value": 10,
        //         "title": "Bogura"
        //         },
        //         {
        //         "value": 38,
        //         "title": "Joypurhat"
        //         },
        //         {
        //         "value": 64,
        //         "title": "Naogaon"
        //         },
        //         {
        //         "value": 69,
        //         "title": "Natore"
        //         },
        //         {
        //         "value": 70,
        //         "title": "Chapainawabganj"
        //         },
        //         {
        //         "value": 76,
        //         "title": "Pabna"
        //         },
        //         {
        //         "value": 81,
        //         "title": "Rajshahi"
        //         },
        //         {
        //         "value": 88,
        //         "title": "Sirajganj"
        //         }
        //     ],
        //     "55": [
        //         {
        //         "value": 27,
        //         "title": "Dinajpur"
        //         },
        //         {
        //         "value": 32,
        //         "title": "Gaibandha"
        //         },
        //         {
        //         "value": 49,
        //         "title": "Kurigram"
        //         },
        //         {
        //         "value": 52,
        //         "title": "Lalmonirhat"
        //         },
        //         {
        //         "value": 73,
        //         "title": "Nilphamari"
        //         },
        //         {
        //         "value": 77,
        //         "title": "Panchagarh"
        //         },
        //         {
        //         "value": 85,
        //         "title": "Rangpur"
        //         },
        //         {
        //         "value": 94,
        //         "title": "Thakurgaon"
        //         }
        //     ],
        //     "60": [
        //         {
        //         "value": 36,
        //         "title": "Habiganj"
        //         },
        //         {
        //         "value": 58,
        //         "title": "Moulvibazar"
        //         },
        //         {
        //         "value": 90,
        //         "title": "Sunamganj"
        //         },
        //         {
        //         "value": 91,
        //         "title": "Sylhet"
        //         }
        //     ]
        //     }', true);

        // $transformedDistricts = [];

        // foreach ($values as $division_key => $division) {
        //     foreach ($division as $district) {
        //         $transformedDistricts[] = [
        //             'id' => $district['value'],
        //             'division_id' => $division_key,
        //             'name' => $district['title'],
        //             'created_at' => Carbon::now()->toDateTimeString(),
        //             'updated_at' => Carbon::now()->toDateTimeString(),
        //         ];
        //     }
        // }

        // District::insert($transformedDistricts);

        // District::Insert(
        //     [
        //         ['id' => '1', 'division_id' => '1', 'name' => 'Comilla', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '2', 'division_id' => '1', 'name' => 'Feni', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '3', 'division_id' => '1', 'name' => 'Brahmanbaria', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '4', 'division_id' => '1', 'name' => 'Rangamati', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '5', 'division_id' => '1', 'name' => 'Noakhali', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '6', 'division_id' => '1', 'name' => 'Chandpur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '7', 'division_id' => '1', 'name' => 'Lakshmipur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '8', 'division_id' => '1', 'name' => 'Chattogram', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '9', 'division_id' => '1', 'name' => 'Coxsbazar', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '10', 'division_id' => '1', 'name' => 'Khagrachhari', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '11', 'division_id' => '1', 'name' => 'Bandarban', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '12', 'division_id' => '2', 'name' => 'Sirajganj', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '13', 'division_id' => '2', 'name' => 'Pabna', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '14', 'division_id' => '2', 'name' => 'Bogura', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '15', 'division_id' => '2', 'name' => 'Rajshahi', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '16', 'division_id' => '2', 'name' => 'Natore', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '17', 'division_id' => '2', 'name' => 'Joypurhat', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '18', 'division_id' => '2', 'name' => 'Chapainawabganj', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '19', 'division_id' => '2', 'name' => 'Naogaon', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '20', 'division_id' => '3', 'name' => 'Jashore', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '21', 'division_id' => '3', 'name' => 'Satkhira', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '22', 'division_id' => '3', 'name' => 'Meherpur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '23', 'division_id' => '3', 'name' => 'Narail', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '24', 'division_id' => '3', 'name' => 'Chuadanga', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '25', 'division_id' => '3', 'name' => 'Kushtia', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '26', 'division_id' => '3', 'name' => 'Magura', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '27', 'division_id' => '3', 'name' => 'Khulna', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '28', 'division_id' => '3', 'name' => 'Bagerhat', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '29', 'division_id' => '3', 'name' => 'Jhenaidah', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '30', 'division_id' => '4', 'name' => 'Jhalakathi', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '31', 'division_id' => '4', 'name' => 'Patuakhali', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '32', 'division_id' => '4', 'name' => 'Pirojpur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '33', 'division_id' => '4', 'name' => 'Barisal', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '34', 'division_id' => '4', 'name' => 'Bhola', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '35', 'division_id' => '4', 'name' => 'Barguna', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '36', 'division_id' => '5', 'name' => 'Sylhet', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '37', 'division_id' => '5', 'name' => 'Moulvibazar', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '38', 'division_id' => '5', 'name' => 'Habiganj', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '39', 'division_id' => '5', 'name' => 'Sunamganj', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '40', 'division_id' => '6', 'name' => 'Narsingdi', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '41', 'division_id' => '6', 'name' => 'Gazipur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '42', 'division_id' => '6', 'name' => 'Shariatpur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '43', 'division_id' => '6', 'name' => 'Narayanganj', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '44', 'division_id' => '6', 'name' => 'Tangail', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '45', 'division_id' => '6', 'name' => 'Kishoreganj', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '46', 'division_id' => '6', 'name' => 'Manikganj', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '47', 'division_id' => '6', 'name' => 'Dhaka', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '48', 'division_id' => '6', 'name' => 'Munshiganj', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '49', 'division_id' => '6', 'name' => 'Rajbari', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '50', 'division_id' => '6', 'name' => 'Madaripur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '51', 'division_id' => '6', 'name' => 'Gopalganj', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '52', 'division_id' => '6', 'name' => 'Faridpur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '53', 'division_id' => '7', 'name' => 'Panchagarh', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '54', 'division_id' => '7', 'name' => 'Dinajpur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '55', 'division_id' => '7', 'name' => 'Lalmonirhat', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '56', 'division_id' => '7', 'name' => 'Nilphamari', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '57', 'division_id' => '7', 'name' => 'Gaibandha', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '58', 'division_id' => '7', 'name' => 'Thakurgaon', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '59', 'division_id' => '7', 'name' => 'Rangpur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '60', 'division_id' => '7', 'name' => 'Kurigram', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '61', 'division_id' => '8', 'name' => 'Sherpur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '62', 'division_id' => '8', 'name' => 'Mymensingh', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '63', 'division_id' => '8', 'name' => 'Jamalpur', 'created_at' => now(), 'updated_at' => now()],
        //         ['id' => '64', 'division_id' => '8', 'name' => 'Netrokona', 'created_at' => now(), 'updated_at' => now()],
        //     ]
        // );

        $array = [
            ['division_id' => 1, 'name' => 'Joypurhat District'],
            ['division_id' => 1, 'name' => 'Bogra District'],
            ['division_id' => 1, 'name' => 'Naogaon District'],
            ['division_id' => 1, 'name' => 'Natore District'],
            ['division_id' => 1, 'name' => 'Nawabganj District'],
            ['division_id' => 1, 'name' => 'Pabna District'],
            ['division_id' => 1, 'name' => 'Sirajganj District'],
            ['division_id' => 1, 'name' => 'Rajshahi District'],
            ['division_id' => 2, 'name' => 'Dinajpur District'],
            ['division_id' => 2, 'name' => 'Gaibandha District'],
            ['division_id' => 2, 'name' => 'Kurigram District'],
            ['division_id' => 2, 'name' => 'Lalmonirhat District'],
            ['division_id' => 2, 'name' => 'Nilphamari District'],
            ['division_id' => 2, 'name' => 'Panchagarh District'],
            ['division_id' => 2, 'name' => 'Rangpur District'],
            ['division_id' => 2, 'name' => 'Thakurgaon District'],
            ['division_id' => 3, 'name' => 'Barguna District'],
            ['division_id' => 3, 'name' => 'Barisal District'],
            ['division_id' => 3, 'name' => 'Bhola District'],
            ['division_id' => 3, 'name' => 'Jhalokati District'],
            ['division_id' => 3, 'name' => 'Patuakhali District'],
            ['division_id' => 3, 'name' => 'Pirojpur District'],
            ['division_id' => 4, 'name' => 'Bandarban District'],
            ['division_id' => 4, 'name' => 'Brahmanbaria District'],
            ['division_id' => 4, 'name' => 'Chandpur District'],
            ['division_id' => 4, 'name' => 'Chittagong District'],
            ['division_id' => 4, 'name' => 'Comilla District'],
            ['division_id' => 4, 'name' => "Cox's Bazar District"],
            ['division_id' => 4, 'name' => 'Feni District'],
            ['division_id' => 4, 'name' => 'Khagrachhari District'],
            ['division_id' => 4, 'name' => 'Lakshmipur District'],
            ['division_id' => 4, 'name' => 'Noakhali District'],
            ['division_id' => 4, 'name' => 'Rangamati District'],
            ['division_id' => 5, 'name' => 'Dhaka District'],
            ['division_id' => 5, 'name' => 'Faridpur District'],
            ['division_id' => 5, 'name' => 'Gazipur District'],
            ['division_id' => 5, 'name' => 'Gopalganj District'],
            ['division_id' => 5, 'name' => 'Jamalpur District'],
            ['division_id' => 5, 'name' => 'Kishoreganj District'],
            ['division_id' => 5, 'name' => 'Madaripur District'],
            ['division_id' => 5, 'name' => 'Manikganj District'],
            ['division_id' => 5, 'name' => 'Munshiganj District'],
            ['division_id' => 5, 'name' => 'Mymensingh District'],
            ['division_id' => 5, 'name' => 'Narayanganj District'],
            ['division_id' => 5, 'name' => 'Netrokona District'],
            ['division_id' => 5, 'name' => 'Rajbari District'],
            ['division_id' => 5, 'name' => 'Shariatpur District'],
            ['division_id' => 5, 'name' => 'Sherpur District'],
            ['division_id' => 5, 'name' => 'Tangail District'],
            ['division_id' => 5, 'name' => 'Narsingdi District'],
            ['division_id' => 6, 'name' => 'Bagerhat District'],
            ['division_id' => 6, 'name' => 'Chuadanga District'],
            ['division_id' => 6, 'name' => 'Jessore District'],
            ['division_id' => 6, 'name' => 'Jhenaida District'],
            ['division_id' => 6, 'name' => 'Khulna District'],
            ['division_id' => 6, 'name' => 'Kushtia District'],
            ['division_id' => 6, 'name' => 'Magura District'],
            ['division_id' => 6, 'name' => 'Meherpur District'],
            ['division_id' => 6, 'name' => 'Narail District'],
            ['division_id' => 6, 'name' => 'Satkhira District'],
            ['division_id' => 7, 'name' => 'Habiganj District'],
            ['division_id' => 7, 'name' => 'Moulvibazar District'],
            ['division_id' => 7, 'name' => 'Sunamganj District'],
            ['division_id' => 7, 'name' => 'Sylhet District'],
        ];

        $insertData = [];
        $id = 1; // Initial ID value

        foreach ($array as $district) {
            $insertData[] = [
                'id' => $id,
                'division_id' => $district['division_id'],
                'name' => $district['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $id++; // Increment ID for each division
        }

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        District::whereNot('id', 0)->delete();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        District::insert($insertData);
    }
}
