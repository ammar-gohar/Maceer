<?php

namespace Modules\Students\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Courses\Models\Course;
use Modules\Enrollments\Models\Enrollment;
use Modules\Levels\Models\Level;

use Modules\Students\Database\Factories\StudentFactory;

class Student extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function requests()
    {
        return $this->belongsToMany(Course::class, 'course_requests', 'student_id', 'course_id');
    }

    public function guide()
    {
        return $this->belongsTo(User::class, 'guide_id');
    }

    protected static function newFactory(): StudentFactory
    {
        return StudentFactory::new();
    }
}
