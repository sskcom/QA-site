<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\questions>
 */
class questionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   

    public function definition()
    {
        $faker = Faker::create();

        return [
            'title' => $faker->sentence(6),
            'tag' => implode(',', $faker->words(3)),
            'answer_count' => 0,
            'is_solved' => false,
            'user_name' => $faker->name,
            'view_count' => 0,
        ];
    }


    
}
