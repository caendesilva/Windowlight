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
        echo '  Seeding page views';
        PageViewEvent::factory(1500)->thisYear()->create();
        echo '.';
        PageViewEvent::factory(750)->pastSixMonths()->create();
        echo '.';
        PageViewEvent::factory(500)->pastThreeMonths()->create();
        echo '.';
        PageViewEvent::factory(250)->thisMonth()->create();
        echo '.';
        PageViewEvent::factory(50)->thisWeek()->create();
        echo '.';
        PageViewEvent::factory(25)->pastThreeDays()->create();
        echo '.';
        PageViewEvent::factory(10)->today()->create();
        echo ".\n";
    }
}
