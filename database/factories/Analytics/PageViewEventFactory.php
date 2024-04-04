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
}
