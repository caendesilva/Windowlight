<?php

namespace Database\Factories\Analytics;

use App\Contracts\Torchlight;
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
            'language' => $this->faker->randomElement($this->getLanguages()),
            'hasMenubar' => $this->faker->boolean(),
            'hasLineNumbers' => $this->faker->boolean(),
            'hasMenuButtons' => $this->faker->boolean(),
            'hasMenubarText' => $this->faker->boolean(),
            'background' => $this->faker->hexColor(),
            'lines' => $this->faker->numberBetween(rand(1, 3), rand(4, rand(10, rand(20, 100)))),
        ];
    }

    /**
     * @return string[]
     */
    protected function getLanguages(): array
    {
        return array_merge(
            $this->arrayRepeat(['php'], 25),
            $this->arrayRepeat(['javascript', 'typescript'], 12),
            $this->arrayRepeat(['php', 'javascript', 'typescript', 'blade'], 10),
            $this->arrayRepeat(['php', 'javascript', 'typescript', 'python', 'ruby'], 7),
            Torchlight::LANGUAGES
        );
    }

    protected function arrayRepeat(array $array, int $times): array
    {
        return array_merge(...array_fill(0, $times, $array));
    }
}
