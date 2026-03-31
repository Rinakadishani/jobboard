<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'salary_min'  => fake()->numberBetween(30000, 80000),
            'salary_max'  => fake()->numberBetween(80000, 150000),
            'location'    => fake()->city(),
            'experience'  => fake()->randomElement(['entry', 'intermediate', 'senior']),
            'type'        => fake()->randomElement(['full-time', 'part-time', 'remote', 'internship']),
            'is_active'   => true,
        ];
    }
}