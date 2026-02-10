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
    protected $description = 'Prevedi sva pitanja u bazi na srpski jezik (latinica) i spoji duplikate kategorija';

    protected array $translatedCategories = [];

    public function handle()
    {
        $questions = Question::with('category')->get();

        foreach ($questions as $question) {
            $this->info("➡️ Prevodi pitanje ID {$question->id}");

            if (!$question->category) {
                $this->error("❌ Pitanje ID {$question->id} nema kategoriju — preskačem.");
                continue;
            }

            if ($this->isSerbian($question->question)) {
                $this->info("⏭ Pitanje ID {$question->id} je već na srpskom — preskačem.");
                continue;
            }

            /** ---------------- KATEGORIJA ---------------- */

            $originalCategoryName = $question->category->name;

            if (!isset($this->translatedCategories[$originalCategoryName])) {
                $translated = $this->translateText($originalCategoryName);
                $translated = $this->cyrillicToLatin($translated);
                $this->translatedCategories[$originalCategoryName] = $translated;
                sleep(1);
            }

            $finalCategoryName = $this->translatedCategories[$originalCategoryName];

            $category = QuestionCategory::firstOrCreate(
                ['name' => $finalCategoryName],
                ['description' => 'Automatski prevedena kategorija']
            );

            /** ---------------- PITANJE ---------------- */

            $translatedQuestion = $this->cyrillicToLatin(
                $this->translateText($question->question)
            );

            $translatedAnswer = $this->cyrillicToLatin(
                $this->translateText($question->answer)
            );

            $optionsArray = is_array($question->options)
                ? $question->options
                : json_decode($question->options, true);

            $translatedOptions = [];

            foreach ($optionsArray as $option) {
                $translatedOptions[] = $this->cyrillicToLatin(
                    $this->translateText($option)
                );
                sleep(1);
            }

            /** ---------------- SAVE ---------------- */

            $question->category_id = $category->id;
            $question->question = $translatedQuestion;
            $question->options = $translatedOptions;
            $question->answer = $translatedAnswer;
            $question->save();

            $this->info("✅ Pitanje ID {$question->id} uspešno prevedeno.");
        }

        $this->mergeDuplicateCategories();

        $this->info('🎉 Sva pitanja i kategorije su obrađeni.');
        return 0;
    }

    /** -------------------------------------------------- */

    private function isSerbian(string $text): bool
    {
        return (bool) preg_match('/[čćšđžČĆŠĐŽ]/u', $text);
    }

    private function translateText(string $text): string
    {
        try {
            $response = Http::timeout(15)->get(
                'https://api.mymemory.translated.net/get',
                [
                    'q' => $text,
                    'langpair' => 'en|sr'
                ]
            );

            if ($response->successful()) {
                return $response->json()['responseData']['translatedText'] ?? $text;
            }

            return $text;

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $text;
        }
    }

    /** -------------------------------------------------- */
    /** Spajanje duplikata kategorija (latinica uvek pobeđuje) */

    private function mergeDuplicateCategories()
    {
        $categories = QuestionCategory::with('questions')->get();
        $grouped = [];

        foreach ($categories as $category) {
            $normalized = mb_strtolower(
                $this->cyrillicToLatin(trim($category->name)),
                'UTF-8'
            );

            $grouped[$normalized][] = $category;
        }

        foreach ($grouped as $group) {
            if (count($group) <= 1) {
                continue;
            }

            // Preferiramo kategoriju koja je već u latinici
            $mainCategory = collect($group)->first(fn ($c) =>
                $c->name === $this->cyrillicToLatin($c->name)
            ) ?? $group[0];

            foreach ($group as $category) {
                if ($category->id === $mainCategory->id) {
                    continue;
                }

                $this->info("🔁 Spajam '{$category->name}' → '{$mainCategory->name}'");

                Question::where('category_id', $category->id)
                    ->update(['category_id' => $mainCategory->id]);

                $category->delete();
            }
        }
    }

    /** -------------------------------------------------- */
    /** Konverzija ćirilice u latinicu */

    private function cyrillicToLatin(string $text): string
    {
        $map = [
            'А'=>'A','Б'=>'B','В'=>'V','Г'=>'G','Д'=>'D','Ђ'=>'Đ','Е'=>'E','Ж'=>'Ž','З'=>'Z','И'=>'I',
            'Ј'=>'J','К'=>'K','Л'=>'L','Љ'=>'Lj','М'=>'M','Н'=>'N','Њ'=>'Nj','О'=>'O','П'=>'P','Р'=>'R',
            'С'=>'S','Т'=>'T','Ћ'=>'Ć','У'=>'U','Ф'=>'F','Х'=>'H','Ц'=>'C','Ч'=>'Č','Џ'=>'Dž','Ш'=>'Š',
            'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','ђ'=>'đ','е'=>'e','ж'=>'ž','з'=>'z','и'=>'i',
            'ј'=>'j','к'=>'k','л'=>'l','љ'=>'lj','м'=>'m','н'=>'n','њ'=>'nj','о'=>'o','п'=>'p','р'=>'r',
            'с'=>'s','т'=>'t','ћ'=>'ć','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'č','џ'=>'dž','ш'=>'š',
        ];

        return strtr($text, $map);
    }
}
