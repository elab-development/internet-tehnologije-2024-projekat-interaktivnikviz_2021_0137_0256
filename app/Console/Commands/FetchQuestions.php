<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Question;
use App\Models\QuestionCategory;

class FetchQuestions extends Command
{
    protected $signature = 'import:opentdb {amount=10} {categoryId?}';
    protected $description = 'Importuje pitanja iz OpenTDB u bazu';

    public function handle()
    {
        $amount = $this->argument('amount');
        $apiUrl = "https://opentdb.com/api.php?amount={$amount}&type=multiple";

        if ($this->argument('categoryId')) {
            $apiUrl .= "&category=" . $this->argument('categoryId');
        }

        $response = Http::get($apiUrl);

        if ($response->failed()) {
            $this->error('Greška pri pozivanju OpenTDB API-ja.');
            return 1;
        }

        $data = $response->json();

        if ($data['response_code'] !== 0) {
            $this->error('OpenTDB API nije vratio pitanja.');
            return 1;
        }

        foreach ($data['results'] as $item) {
            $categoryName = $item['category'];

            // Pronađi ili kreiraj kategoriju
            $category = QuestionCategory::firstOrCreate(
                ['name' => $categoryName],
                ['description' => 'Uvezena iz OpenTDB']
            );

            // Kreiraj opcije (tačan + netačni odgovori)
            $options = $item['incorrect_answers'];
            $options[] = $item['correct_answer'];
            shuffle($options); // pomešaj

            // Unesi pitanje u bazu
            Question::create([
                'category_id' => $category->id,
                'question' => html_entity_decode($item['question']),
                'options' => json_encode($options), // važno!
                'answer' => $item['correct_answer'],
                'points' => 1
            ]);
        }

        $this->info('Pitanja uspešno uvezena.');
        return 0;
    }
}
