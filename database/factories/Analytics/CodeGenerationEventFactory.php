<?php

namespace Database\Factories\Analytics;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Analytics\CodeGenerationEvent>
 */
class CodeGenerationEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'language' => $this->faker->randomElement(['php', 'javascript', 'typescript', 'python', 'ruby']),
            'hasMenubar' => $this->faker->boolean(),
            'hasLineNumbers' => $this->faker->boolean(),
            'hasMenuButtons' => $this->faker->boolean(),
            'hasMenubarText' => $this->faker->boolean(),
            'background' => $this->faker->hexColor(),
            'lines' => $this->faker->numberBetween(1, 100),
        ];
    }
}
