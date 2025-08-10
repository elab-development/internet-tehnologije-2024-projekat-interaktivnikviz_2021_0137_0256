<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionCategory;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Dohvat svih kategorija
        $categories = QuestionCategory::all();

        foreach ($categories as $category) {
            switch ($category->name) {
                case 'Istorija':
                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koje godine je počeo Drugi svetski rat?',
                        'options' => ['1939', '1941', '1914', '1945'],
                        'answer' => '1939',
                        'points' => 5,
                    ]);

                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koji francuski kralj je bio poznat kao Kralj Sunce?',
                        'options' => ['Luj XIV', 'Luj XVI', 'Karlo Veliki', 'Napoleon'],
                        'answer' => 'Luj XIV',
                        'points' => 15,
                    ]);
                    break;

                case 'Geografija':
                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koji je najveći kontinent na svetu?',
                        'options' => ['Azija', 'Afrika', 'Evropa', 'Antarktik'],
                        'answer' => 'Azija',
                        'points' => 5,
                    ]);

                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koja je najduža reka na svetu?',
                        'options' => ['Nil', 'Amazon', 'Misisipi', 'Jangce'],
                        'answer' => 'Amazon',
                        'points' => 15,
                    ]);
                    break;

                case 'Filmovi i serije':
                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koji film je prvi dobio Oskara za najbolji film?',
                        'options' => ['Krila', 'Prohujalo sa vihorom', 'Građanin Kejn', 'Casablanca'],
                        'answer' => 'Krila',
                        'points' => 5,
                    ]);

                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Kako se zove zmajeva majka u seriji "Igra prestola"?',
                        'options' => ['Daenerys Targaryen', 'Cersei Lannister', 'Arya Stark', 'Sansa Stark'],
                        'answer' => 'Daenerys Targaryen',
                        'points' => 15,
                    ]);
                    break;

                case 'Sport':
                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koliko igrača ima fudbalski tim na terenu?',
                        'options' => ['11', '10', '9', '12'],
                        'answer' => '11',
                        'points' => 5,
                    ]);

                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Ko je osvojio najviše Grand Slam titula u tenisu do 2024. godine?',
                        'options' => ['Novak Đoković', 'Roger Federer', 'Rafael Nadal', 'Pete Sampras'],
                        'answer' => 'Novak Đoković',
                        'points' => 15,
                    ]);
                    break;

                case 'Muzika':
                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koja grupa je poznata po pesmi "Bohemian Rhapsody"?',
                        'options' => ['Queen', 'The Beatles', 'Pink Floyd', 'Led Zeppelin'],
                        'answer' => 'Queen',
                        'points' => 5,
                    ]);

                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koji je bio nadimak Ludviga van Betovena?',
                        'options' => ['Virtuoz', 'Božanski Ton', 'Titan Muzičkog Sveta', 'Bonski Virtuoz'],
                        'answer' => 'Bonski Virtuoz',
                        'points' => 15,
                    ]);
                    break;

                case 'Nauka':
                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koji planet je najbliži Suncu?',
                        'options' => ['Merkur', 'Venera', 'Mars', 'Zemlja'],
                        'answer' => 'Merkur',
                        'points' => 5,
                    ]);

                    Question::create([
                        'category_id' => $category->id,
                        'question' => 'Koji naučnik je formulisao teoriju opšte relativnosti?',
                        'options' => ['Albert Ajnštajn', 'Isaak Njutn', 'Nikola Tesla', 'Galileo Galilej'],
                        'answer' => 'Albert Ajnštajn',
                        'points' => 15,
                    ]);
                    break;
            }
        }
    }
}
