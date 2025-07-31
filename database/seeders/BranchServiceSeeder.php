<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\Service;

class BranchServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();
        $services = Service::all();

        // Assign all services to all branches
        foreach ($branches as $branch) {
            // Each branch offers all services
            $branch->services()->attach($services->pluck('id'));
        }
    }
}
