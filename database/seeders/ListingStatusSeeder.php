<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListingStatusSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\ListingStatus::factory()->create([
             'name' => 'Active',
         ]);
        \App\Models\ListingStatus::factory()->create([
            'name' => 'Sold',
        ]);
        \App\Models\ListingStatus::factory()->create([
            'name' => 'Deleted',
        ]);
    }
}
