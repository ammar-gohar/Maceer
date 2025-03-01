<?php

namespace Modules\Enrollments\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Courses\Models\Course;

// use Modules\Enrollments\Database\Factories\EnrollmentFactory;

class Enrollment extends Model
{
    use HasFactory;

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
        return $this->belongsTo(User::class, 'student_id');
    }

    // protected static function newFactory(): EnrollmentFactory
    // {
    //     // return EnrollmentFactory::new();
    // }
}
