<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provider;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        Provider::create([
            'name' => 'Bolt',
            'slug' => 'bolt',
            'deep_link_url' => 'bolt://',
            'api_available' => false,
            'is_active' => true,
            'base_fare' => 5.00,
            'per_km_rate' => 3.50,
            'per_minute_rate' => 0.50,
        ]);

        Provider::create([
            'name' => 'Uber',
            'slug' => 'uber',
            'deep_link_url' => 'uber://',
            'api_available' => false,
            'is_active' => true,
            'base_fare' => 6.00,
            'per_km_rate' => 3.80,
            'per_minute_rate' => 0.55,
        ]);

        Provider::create([
            'name' => 'inDrive',
            'slug' => 'indrive',
            'deep_link_url' => 'indrive://',
            'api_available' => false,
            'is_active' => true,
            'base_fare' => 4.50,
            'per_km_rate' => 3.00,
            'per_minute_rate' => 0.45,
        ]);

        Provider::create([
            'name' => 'Local Taxi',
            'slug' => 'local-taxi',
            'deep_link_url' => null,
            'api_available' => false,
            'is_active' => true,
            'base_fare' => 4.00,
            'per_km_rate' => 2.50,
            'per_minute_rate' => 0.40,
        ]);
    }
}