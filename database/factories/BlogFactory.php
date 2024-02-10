<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->jobTitle(),
            // 'image' => $filename,
            'category' => fake()->text(),
            'user_id' => \App\Models\User::all()->random()->id,
            'summary' => fake()->paragraph(),
            'blog_content' => fake()->paragraph(),
            //
        ];
    }
}
