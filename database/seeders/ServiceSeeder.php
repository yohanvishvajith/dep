<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Account Opening'],
            ['name' => 'Loan Application'],
            ['name' => 'Credit Card Services'],
            ['name' => 'Investment Consultation'],
            ['name' => 'Insurance Services'],
            ['name' => 'Money Transfer'],
            ['name' => 'Fixed Deposit'],
            ['name' => 'Customer Support'],
            ['name' => 'Document Verification'],
            ['name' => 'Tax Services']
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
