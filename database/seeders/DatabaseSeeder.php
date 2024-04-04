<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // We seed page views with a custom distribution of dates
        \App\Models\Analytics\PageViewEvent::factory()->count(250)->thisYear()->create();
        \App\Models\Analytics\PageViewEvent::factory()->count(100)->thisMonth()->create();
        \App\Models\Analytics\PageViewEvent::factory()->count(50)->thisWeek()->create();
        \App\Models\Analytics\PageViewEvent::factory()->count(25)->pastThreeDays()->create();
        \App\Models\Analytics\PageViewEvent::factory()->count(25)->today()->create();
    }
}
