<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'question',
        'options',
        'answer',
        'points',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array', // Automatski dekodira JSON u PHP array
    ];

    /**
     * Povezivanje sa kategorijama pitanja
     */
    public function category()
    {
        return $this->belongsTo(QuestionCategory::class, 'category_id');
    }
}
