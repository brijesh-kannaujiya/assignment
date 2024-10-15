<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'urgency_level' => 'urgent',
            'duration_minutes' => 60,
            'delivery_distance' => 'long',
            'status' => 'pending'
        ]);

        Order::create([
            'urgency_level' => 'urgent',
            'duration_minutes' => 30,
            'delivery_distance' => 'medium',
            'status' => 'pending'
        ]);
 
        Order::create([
            'urgency_level' => 'standard',
            'duration_minutes' => 30,
            'delivery_distance' => 'medium',
            'status' => 'pending'
        ]);

        Order::create([
            'urgency_level' => 'standard',
            'duration_minutes' => 15,
            'delivery_distance' => 'short',
            'status' => 'pending'
        ]);
 
        Order::create([
            'urgency_level' => 'low',
            'duration_minutes' => 15,
            'delivery_distance' => 'short',
            'status' => 'pending'
        ]);

        Order::create([
            'urgency_level' => 'low',
            'duration_minutes' => 30,
            'delivery_distance' => 'medium',
            'status' => 'pending'
        ]);

    }
}
