<?php

namespace Modules\Quizzes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Quizzes\Database\Factories\QuestionOptionFactory;

class QuestionOption extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    // protected static function newFactory(): QuestionOptionFactory
    // {
    //     // return QuestionOptionFactory::new();
    // }
}
