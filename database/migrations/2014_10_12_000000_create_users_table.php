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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default('player'); // Ovo pamti ulogu korisnika
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable(); // Ovo pamti kada je korisnik potvrdio email
            $table->rememberToken(); // Ovo se koristi za Remember me funkcionalnost
            $table->timestamps(); // Ovo pamti kada je korisnik kreiran i kada je poslednji put ažuriran 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
