<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Question;
use App\Models\QuestionCategory;

class FetchQuestions extends Command
{
    protected $signature = 'import:opentdb {amount=10} {categoryId?}';
    protected $description = 'Importuje pitanja iz OpenTDB u bazu sa prevodom na srpski';

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
            $originalCategory = $item['category'];
            $translatedCategory = $this->translateToSerbian($originalCategory);

            if (!$translatedCategory || trim($translatedCategory) === '') {
                $this->error("Upozorenje: prazna kategorija za: " . $originalCategory);
                $translatedCategory = $originalCategory;
            }

            $originalQuestion = html_entity_decode($item['question']);
            $translatedQuestion = $this->translateToSerbian($originalQuestion);

            $originalCorrect = html_entity_decode($item['correct_answer']);
            $translatedCorrect = $this->translateToSerbian($originalCorrect);

            $translatedIncorrect = [];
            foreach ($item['incorrect_answers'] as $wrong) {
                $translatedIncorrect[] = $this->translateToSerbian(html_entity_decode($wrong));
            }

            $allOptions = $translatedIncorrect;
            $allOptions[] = $translatedCorrect;
            shuffle($allOptions);

            $category = QuestionCategory::firstOrCreate(
                ['name' => $translatedCategory],
                ['description' => 'Uvezena iz OpenTDB']
            );

            Question::create([
                'category_id' => $category->id,
                'question' => $translatedQuestion,
                'options' => json_encode($allOptions),
                'answer' => $translatedCorrect,
                'points' => 1
            ]);
        }

        $this->info('Pitanja uspešno uvezena.');
        return 0;
    }

    private function translateToSerbian(string $text): ?string
    {
        // Endpoint LibreTranslate
        $response = Http::post('https://libretranslate.de/translate', [
            'q' => $text,
            'source' => 'en',
            'target' => 'sr',
            'format' => 'text'
        ]);

        if ($response->successful()) {
            $json = $response->json();
            return $json['translatedText'] ?? $text;
        }

        // Ako ne uspe, vrati originalni tekst (fallback)
        return $text;
    }
}
