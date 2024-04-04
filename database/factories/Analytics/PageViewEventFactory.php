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
            'anonymous_id' => $this->getAnonymousId(),
        ];
    }

    public function thisYear(): static
    {
        return $this->withInterval('-1 year');
    }

    public function pastSixMonths(): static
    {
        return $this->withInterval('-6 months');
    }

    public function pastThreeMonths(): static
    {
        return $this->withInterval('-3 months');
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

    public function getAnonymousId(): string
    {
        $chanceOfBeingAnonymous = 50;
        $uniqueUsersCount = 10;

        // We factor in the unique user count, as the randomization affects the distribution
        $shouldBeAnonymous = $this->faker->boolean(($chanceOfBeingAnonymous - ($uniqueUsersCount * 3)) - 20);

        if ($shouldBeAnonymous) {
            return $this->faker->sha1;
        } else {
            // Return a subset of "known" users
            return substr(hash('sha256', rand(1, $uniqueUsersCount)), 0, 40);
        }
    }
}
