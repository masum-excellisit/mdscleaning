<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $hasCustomerRole = Role::where('name', 'customer')->exists();

        $customers = [
            [
                'name'    => 'Aanya Banerjee',
                'email'   => 'customer1@example.com',
                'phone'   => '+91 90000 00001',
                'address' => ['Home', 'Aanya Banerjee', '+91 90000 00001', '24/B Park Street', null, 'Kolkata', 'West Bengal', '700016', 'India'],
            ],
            [
                'name'    => 'Rohan Mehta',
                'email'   => 'customer2@example.com',
                'phone'   => '+91 90000 00002',
                'address' => ['Home', 'Rohan Mehta', '+91 90000 00002', '12 Linking Road', 'Bandra West', 'Mumbai', 'Maharashtra', '400050', 'India'],
            ],
            [
                'name'    => 'Sneha Iyer',
                'email'   => 'customer3@example.com',
                'phone'   => '+91 90000 00003',
                'address' => ['Office', 'Sneha Iyer', '+91 90000 00003', '101 MG Road', null, 'Bengaluru', 'Karnataka', '560001', 'India'],
            ],
            [
                'name'    => 'Karan Singh',
                'email'   => 'customer4@example.com',
                'phone'   => '+91 90000 00004',
                'address' => ['Home', 'Karan Singh', '+91 90000 00004', '7-A South Extension', 'Part II', 'New Delhi', 'Delhi', '110049', 'India'],
            ],
            [
                'name'    => 'Meera Pillai',
                'email'   => 'customer5@example.com',
                'phone'   => '+91 90000 00005',
                'address' => ['Home', 'Meera Pillai', '+91 90000 00005', '88 Marine Drive', null, 'Kochi', 'Kerala', '682011', 'India'],
            ],
        ];

        foreach ($customers as $c) {
            $user = User::firstOrCreate(
                ['email' => $c['email']],
                [
                    'name'              => $c['name'],
                    'phone'             => $c['phone'],
                    'password'          => Hash::make('Customer@123'),
                    'status'            => 'active',
                    'email_verified_at' => now(),
                ]
            );

            if ($hasCustomerRole && ! $user->hasRole('customer')) {
                $user->assignRole('customer');
            }

            [$label, $name, $phone, $line1, $line2, $city, $state, $zip, $country] = $c['address'];
            Address::firstOrCreate(
                ['user_id' => $user->id, 'line1' => $line1],
                [
                    'label'      => $label,
                    'name'       => $name,
                    'phone'      => $phone,
                    'line2'      => $line2,
                    'city'       => $city,
                    'state'      => $state,
                    'zip'        => $zip,
                    'country'    => $country,
                    'is_default' => true,
                ]
            );
        }

        $this->command->info('Customers seeded (' . count($customers) . '). Login: customer1@example.com / Customer@123');
    }
}
