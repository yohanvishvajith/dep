<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Main Branch',
                'location' => 'Downtown, City Center'
            ],
            [
                'name' => 'North Branch',
                'location' => 'North Avenue, Shopping Mall'
            ],
            [
                'name' => 'South Branch',
                'location' => 'South Street, Business District'
            ],
            [
                'name' => 'East Branch',
                'location' => 'East Park, Residential Area'
            ],
            [
                'name' => 'West Branch',
                'location' => 'West Plaza, Commercial Hub'
            ]
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }
    }
}
