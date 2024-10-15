<?php

namespace Database\Seeders;

use App\Models\DeliveryPersonnel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryPersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryPersonnel::create([
            'name' => 'J',
            'skill_level' => 'expert',
            'max_orders' => 4,
            'current_orders' => 0,
            'last_assigned_at' => null
        ]);

        DeliveryPersonnel::create([
            'name' => 'K',
            'skill_level' => 'intermediate',
            'max_orders' => 6,
            'current_orders' => 0,
            'last_assigned_at' => null
        ]);

        DeliveryPersonnel::create([
            'name' => 'L',
            'skill_level' => 'beginner',
            'max_orders' => 3,
            'current_orders' => 0,
            'last_assigned_at' => null
        ]);

        DeliveryPersonnel::create([
            'name' => 'M',
            'skill_level' => 'expert',
            'max_orders' => 5,
            'current_orders' => 0,
            'last_assigned_at' => null
        ]);

        DeliveryPersonnel::create([
            'name' => 'N',
            'skill_level' => 'intermediate',
            'max_orders' => 4,
            'current_orders' => 0,
            'last_assigned_at' => null
        ]);

        DeliveryPersonnel::create([
            'name' => 'O',
            'skill_level' => 'beginner',
            'max_orders' => 2,
            'current_orders' => 0,
            'last_assigned_at' => null
        ]);


    }
}
