<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\Service;
use App\Models\Ticket;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = Branch::all();
        $services = Service::all();
        
        $statuses = ['waiting', 'called', 'serving', 'completed'];
        $customers = [
            ['name' => 'John Doe', 'mobile' => '9876543210'],
            ['name' => 'Jane Smith', 'mobile' => '8765432109'],
            ['name' => 'Mike Johnson', 'mobile' => '7654321098'],
            ['name' => 'Sarah Wilson', 'mobile' => '6543210987'],
            ['name' => 'David Brown', 'mobile' => '9543210876']
        ];

        $counter = 1;
        
        foreach ($customers as $index => $customer) {
            $tokenPrefix = chr(65 + ($index % 26)); // A, B, C, etc.
            $tokenNumber = sprintf('%05d', $counter);
            
            Ticket::create([
                'branch_id' => $branches->random()->id,
                'service_id' => $services->random()->id,
                'customer_name' => $customer['name'],
                'mobile_number' => $customer['mobile'],
               
            ]);
            
            $counter++;
        }
    }
}
