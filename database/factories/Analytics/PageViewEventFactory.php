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
        return $this->state(function (): array {
            return [
                'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function thisMonth(): static
    {
        return $this->state(function (): array {
            return [
                'created_at' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function thisWeek(): static
    {
        return $this->state(function (): array {
            return [
                'created_at' => $this->faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function pastThreeDays(): static
    {
        return $this->state(function (): array {
            return [
                'created_at' => $this->faker->dateTimeBetween('-3 days', 'now')->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function today(): static
    {
        return $this->state(function (): array {
            return [
                'created_at' => $this->faker->dateTimeBetween('-1 day', 'now')->format('Y-m-d H:i:s'),
            ];
        });
    }
}
