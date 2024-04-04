<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Analytics\PageViewEvent;
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
        PageViewEvent::factory(1500)->thisYear()->create();
        PageViewEvent::factory(750)->pastSixMonths()->create();
        PageViewEvent::factory(500)->pastThreeMonths()->create();
        PageViewEvent::factory(250)->thisMonth()->create();
        PageViewEvent::factory(50)->thisWeek()->create();
        PageViewEvent::factory(25)->pastThreeDays()->create();
        PageViewEvent::factory(10)->today()->create();
    }
}
