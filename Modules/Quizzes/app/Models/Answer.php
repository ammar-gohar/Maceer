<?php

namespace Modules\Quizzes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Quizzes\Database\Factories\AnswerFactory;

class Answer extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function attempt()
    {
        return $this->belongsTo(Attemp::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    // protected static function newFactory(): AnswerFactory
    // {
    //     // return AnswerFactory::new();
    // }
}
