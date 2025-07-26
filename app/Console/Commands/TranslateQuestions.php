<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslateQuestions extends Command
{
    protected $signature = 'translate:questions';
    protected $description = 'Prevedi sva pitanja u bazi na srpski jezik';

    protected array $translatedCategories = [];

    public function handle()
    {
        $questions = Question::with('category')->get();

        foreach ($questions as $question) {
            $this->info("Prevodi pitanje ID {$question->id}");

            if (!$question->category) {
                $this->error("Pitanje ID {$question->id} nema kategoriju — preskačem.");
                continue;
            }

            if ($this->isSerbian($question->question)) {
                $this->info("Pitanje ID {$question->id} je već na srpskom — preskačem.");
                continue;
            }

            $originalCategoryName = $question->category->name;

            if (!isset($this->translatedCategories[$originalCategoryName])) {
                $this->translatedCategories[$originalCategoryName] = $this->translateText($originalCategoryName);
                sleep(1);
            }

            $translatedCategoryName = $this->translatedCategories[$originalCategoryName];
            $translatedQuestionText = $this->translateText($question->question);
            $translatedAnswer = $this->translateText($question->answer);

            $optionsArray = is_array($question->options) ? $question->options : json_decode($question->options, true);
            $translatedOptions = [];

            foreach ($optionsArray as $option) {
                $translatedOptions[] = $this->translateText($option);
                sleep(1);
            }

            $category = QuestionCategory::firstOrCreate(
                ['name' => $translatedCategoryName],
                ['description' => 'Automatski prevedena kategorija']
            );

            $question->category_id = $category->id;
            $question->question = $translatedQuestionText;
            $question->options = $translatedOptions;
            $question->answer = $translatedAnswer;

            $question->save();

            $this->info("Pitanje ID {$question->id} uspešno prevedeno.");
        }

        // Dodato brisanje engleskih kategorija koje nisu više u upotrebi
        $this->deleteUnusedEnglishCategories();

        $this->info('✅ Sva pitanja su prevedena.');
        return 0;
    }

    private function isSerbian(string $text): bool
    {
        return (bool) preg_match('/[čćšđžČĆŠĐŽ]/u', $text);
    }

    private function translateText(string $text): string
    {
        try {
            $response = Http::timeout(15)->get('https://api.mymemory.translated.net/get', [
                'q' => $text,
                'langpair' => 'en|sr'
            ]);

            if ($response->successful()) {
                $translated = $response->json()['responseData']['translatedText'] ?? $text;
                Log::info("Prevod za '{$text}': '{$translated}'");
                return $translated;
            }

            $this->error("❌ Greška pri prevodu: '{$text}'");
            return $text;

        } catch (\Exception $e) {
            $this->error("⚠️ Exception: " . $e->getMessage());
            return $text;
        }
    }

    /**
     * Briše engleske kategorije koje nemaju nijedno pitanje i nisu prevedene.
     */
    private function deleteUnusedEnglishCategories()
    {
        $englishCategories = QuestionCategory::whereDoesntHave('questions')->get();

        foreach ($englishCategories as $category) {
            if (!preg_match('/[čćšđžČĆŠĐŽ]/u', $category->name)) {
                $this->info("🗑 Brišem englesku kategoriju: {$category->name}");
                $category->delete();
            }
        }
    }
}
