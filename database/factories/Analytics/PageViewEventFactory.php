<?php

namespace Database\Factories\Analytics;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Analytics\PageViewEvent>
 */
class PageViewEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page' => $this->faker->url,
            'referrer' => $this->faker->url,
            'user_agent' => $this->faker->userAgent,
            'anonymous_id' => $this->faker->sha1,
        ];
    }

    public function thisYear(): static
    {
        return $this->withInterval('-1 year');
    }

    public function thisMonth(): static
    {
        return $this->withInterval('-1 month');
    }

    public function thisWeek(): static
    {
        return $this->withInterval('-1 week');
    }

    public function pastThreeDays(): static
    {
        return $this->withInterval('-3 days');
    }

    public function today(): static
    {
        return $this->withInterval('-1 day');
    }

    public function withInterval(string $interval): PageViewEventFactory
    {
        return $this->state(function () use ($interval): array {
            return [
                'created_at' => $this->faker->dateTimeBetween($interval, 'now')->format('Y-m-d H:i:s'),
            ];
        });
    }
}
