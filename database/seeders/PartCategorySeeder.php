<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartCategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\PartCategory::factory()->create([
             'name' => 'Breadboard',
         ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Keyboard',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Battery',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Fan',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Heatsink',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Mouse',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Screen',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Cable/Connectivity',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'RAM chip',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'CPU chip',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'GPUs',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Modem',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Storage',
        ]);
        \App\Models\PartCategory::factory()->create([
            'name' => 'Computer',
        ]);
    }
}
