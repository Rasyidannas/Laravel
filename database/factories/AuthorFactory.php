<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    //this is factory callbacks
    public function configure(): static
    {
        
        $profile = new Profile();

        return $this->afterCreating(function (Author $author) use ($profile) {
            $author->profile()->save($profile::factory()->make());
        });

        return $this->afterMaking(function (Author $author) use ($profile) {
            $author->profile()->save($profile::factory()->make());
        });
    }
}
