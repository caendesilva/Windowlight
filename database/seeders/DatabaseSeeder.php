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
        $factor = 2;
        echo '  Seeding page views';
        PageViewEvent::factory(1500 * $factor)->thisYear()->create();
        echo '.';
        PageViewEvent::factory(750 * $factor)->pastSixMonths()->create();
        echo '.';
        PageViewEvent::factory(500 * $factor)->pastThreeMonths()->create();
        echo '.';
        PageViewEvent::factory(250 * $factor)->thisMonth()->create();
        echo '.';
        PageViewEvent::factory(50 * $factor)->thisWeek()->create();
        echo '.';
        PageViewEvent::factory(25 * $factor)->pastThreeDays()->create();
        echo '.';
        PageViewEvent::factory(10 * $factor)->today()->create();
        echo ".\n";

        // Seed code generation events
        echo '  Seeding code generation events';
        \App\Models\Analytics\CodeGenerationEvent::factory(100)->create();
        echo ".\n";
    }
}
