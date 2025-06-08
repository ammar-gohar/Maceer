<?php

namespace Modules\Quizzes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Courses\Models\Course;

// use Modules\Quizzes\Database\Factories\QuizFactory;

class Quiz extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    protected $table = 'quizzes';

    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function attempts()
    {
        return $this->hasMany(Attemp::class, 'quiz_id');
    }

    public function studentAttempt($id)
    {
        return $this->attempts->where('student_id', $id);
    }

    // protected static function newFactory(): QuizFactory
    // {
    //     // return QuizFactory::new();
    // }
}
