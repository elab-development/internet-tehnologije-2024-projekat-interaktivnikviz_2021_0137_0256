<?php

namespace Database\Factories;

use App\Models\QuestionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionCategoryFactory extends Factory
{
    protected $model = QuestionCategory::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Nasumično ime kategorije
            'description' => $this->faker->sentence(10), // Nasumičan opis kategorije
        ];
    }
}

