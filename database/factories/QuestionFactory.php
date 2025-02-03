<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'category_id' => QuestionCategory::factory(), // Kreira povezanu kategoriju ako ne postoji
            'question' => $this->faker->sentence(10), // Generiše nasumično pitanje
            'options' => json_encode([
                $this->faker->word,
                $this->faker->word,
                $this->faker->word,
                $this->faker->word
            ]), // Generiše 4 nasumična odgovora
            'answer' => $this->faker->randomElement(['A', 'B', 'C', 'D']), // Nasumičan tačan odgovor
            'points' => $this->faker->numberBetween(1, 10), // Nasumičan broj poena
        ];
    }
}
