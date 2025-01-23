<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question; // Import modela Question
use App\Models\QuestionCategory; // Import modela QuestionCategory

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          // Prvo dohvatamo ID-ove kategorija
          $categories = QuestionCategory::all();

          // Iteriramo kroz kategorije i dodajemo pitanja
          foreach ($categories as $category) {
              switch ($category->name) {
                  case 'Istorija':
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koje godine je počeo Drugi svetski rat?',
                          'options' => json_encode(['1939', '1941', '1914', '1945']),
                          'answer' => '1939',
                          'points' => 5,
                      ]);
  
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koji francuski kralj je bio poznat kao Kralj Sunce?',
                          'options' => json_encode(['Luj XIV', 'Luj XVI', 'Karlo Veliki', 'Napoleon']),
                          'answer' => 'Luj XIV',
                          'points' => 15,
                      ]);
                      break;
  
                  case 'Geografija':
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koji je najveći kontinent na svetu?',
                          'options' => json_encode(['Azija', 'Afrika', 'Evropa', 'Antarktik']),
                          'answer' => 'Azija',
                          'points' => 5,
                      ]);
  
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koja je najduža reka na svetu?',
                          'options' => json_encode(['Nil', 'Amazon', 'Misisipi', 'Jangce']),
                          'answer' => 'Amazon',
                          'points' => 15,
                      ]);
                      break;
  
                  case 'Filmovi i serije':
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koji film je prvi dobio Oskara za najbolji film?',
                          'options' => json_encode(['Krila', 'Prohujalo sa vihorom', 'Građanin Kejn', 'Casablanca']),
                          'answer' => 'Krila',
                          'points' => 5,
                      ]);
  
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Kako se zove zmajeva majka u seriji "Igra prestola"?',
                          'options' => json_encode(['Daenerys Targaryen', 'Cersei Lannister', 'Arya Stark', 'Sansa Stark']),
                          'answer' => 'Daenerys Targaryen',
                          'points' => 15,
                      ]);
                      break;
  
                  case 'Sport':
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koliko igrača ima fudbalski tim na terenu?',
                          'options' => json_encode(['11', '10', '9', '12']),
                          'answer' => '11',
                          'points' => 5,
                      ]);
  
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Ko je osvojio najviše Grand Slam titula u tenisu do 2024. godine?',
                          'options' => json_encode(['Novak Đoković', 'Roger Federer', 'Rafael Nadal', 'Pete Sampras']),
                          'answer' => 'Novak Đoković',
                          'points' => 15,
                      ]);
                      break;
  
                  case 'Muzika':
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koja grupa je poznata po pesmi "Bohemian Rhapsody"?',
                          'options' => json_encode(['Queen', 'The Beatles', 'Pink Floyd', 'Led Zeppelin']),
                          'answer' => 'Queen',
                          'points' => 5,
                      ]);
  
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koji je bio nadimak Ludviga van Betovena?',
                          'options' => json_encode(['Virtuoz', 'Božanski Ton', 'Titan Muzičkog Sveta', 'Bonski Virtuoz']),
                          'answer' => 'Bonski Virtuoz',
                          'points' => 15,
                      ]);
                      break;
  
                  case 'Nauka':
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koji planet je najbliži Suncu?',
                          'options' => json_encode(['Merkur', 'Venera', 'Mars', 'Zemlja']),
                          'answer' => 'Merkur',
                          'points' => 5,
                      ]);
  
                      Question::create([
                          'category_id' => $category->id,
                          'question' => 'Koji naučnik je formulisao teoriju opšte relativnosti?',
                          'options' => json_encode(['Albert Ajnštajn', 'Isaak Njutn', 'Nikola Tesla', 'Galileo Galilej']),
                          'answer' => 'Albert Ajnštajn',
                          'points' => 15,
                      ]);
                      break;
                    }
                }
    }
}
