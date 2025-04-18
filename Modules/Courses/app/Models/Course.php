<?php

namespace Modules\Courses\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Enrollments\Models\Enrollment;

// use Modules\Courses\Database\Factories\CourseFactory;

class Course extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

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

    public function prerequests()
    {
        return $this->belongsToMany(Course::class, 'course_prerequest', 'course_id', 'prerequest_id')->withTimestamps();
    }

    // protected static function newFactory(): CourseFactory
    // {
    //     // return CourseFactory::new();
    // }

}
