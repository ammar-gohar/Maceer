<?php

namespace Modules\Courses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Students\Models\Student;

// use Modules\Courses\Database\Factories\CourseRequestFactory;

class CourseRequest extends Model
{
    use HasFactory;
    protected $table = 'course_requests';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // protected static function newFactory(): CourseRequestFactory
    // {
    //     // return CourseRequestFactory::new();
    // }
}
