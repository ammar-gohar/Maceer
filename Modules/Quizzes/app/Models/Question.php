<?php

namespace Modules\Quizzes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Quizzes\Database\Factories\QuestionFactory;

class Question extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function options()
    {
        return $this->hasMany(QuestionOption::class, 'question_id');
    }

    public function correct_option()
    {
        return $this->hasOne(QuestionOption::class, 'question_id')->where('is_correct', 1);
    }

    // protected static function newFactory(): QuestionFactory
    // {
    //     // return QuestionFactory::new();
    // }
}
