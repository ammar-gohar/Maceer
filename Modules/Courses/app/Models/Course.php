<?php

namespace Modules\Courses\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Enrollments\Models\Enrollment;

// use Modules\Courses\Database\Factories\CourseFactory;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function professors()
    {
        return $this->belongsToMany(User::class, 'course_professor');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function currentSemesterEnrollemnts()
    {
        return $this->whereHas('enrollments', function ($q) {
            $q
                ->where('year', \Carbon\Carbon::thisYear())
                ->where('semester', 2);
        });
    }

    // protected static function newFactory(): CourseFactory
    // {
    //     // return CourseFactory::new();
    // }

}
