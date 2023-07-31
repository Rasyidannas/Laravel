<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blogpost>
 */
class BlogpostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(10),
            'content' => fake()->paragraphs(5, true),
            'created_at' => fake()->dateTimeBetween('-3 months')
        ];
    }

    //factory state is for custom and if one is missng column it will use defination factory
    public function suspended(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'New Title',
                'content' => 'Content of the Blog post'
            ];
        });
    }
}
