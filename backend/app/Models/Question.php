<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question_text', 'type', 'order'];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public static function getOrderedQuestions()
    {
        return self::orderBy('order')->get();
    }
}
