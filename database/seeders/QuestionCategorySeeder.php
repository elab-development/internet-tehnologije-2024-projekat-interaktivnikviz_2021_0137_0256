<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //generisu se primeri vrednosti za kategorije pitanja
        \App\Models\QuestionCategory::create([
            'name' => 'Istorija',
            'description' => 'Pitanja iz svetske i domaće istorije.',
        ]);
    
        \App\Models\QuestionCategory::create([
            'name' => 'Geografija',
            'description' => 'Pitanja iz geografije i geopolitike.',
        ]);
        \App\Models\QuestionCategory::create([
            'name' => 'Filmovi i serije',
            'description' => 'Pitanja iz raznih filmova i serija',
        ]);
        \App\Models\QuestionCategory::create([
            'name' => 'Sport',
            'description' => 'Pitanja iz raznih sportova.',
        ]);
        \App\Models\QuestionCategory::create([
            'name' => 'Muzika',
            'description' => 'Pitanja iz muzike.',
        ]);
        \App\Models\QuestionCategory::create([
            'name' => 'Nauka',
            'description' => 'Pitanja iz raznih prirodnih nauka.',
        ]);
    }
}
