<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('question_categories')->onDelete('cascade'); // Veza sa tabelom question_category (da se zna kojoj kategoriji pitanje pripada)
            $table->string('question'); // Ovo pamti pitanje
            $table->json('options'); // Ovo pamti odgovore u JSON formatu
            $table->string('answer'); // Ovo pamti odgovor na pitanje
            $table->integer('points'); // Ovo pamti koliko pitanje nosi poena
            $table->timestamps(); // Ovo pamti kada je pitanje napravljeno ili azurirano
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
