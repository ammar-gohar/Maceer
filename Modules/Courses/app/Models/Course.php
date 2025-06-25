<?php

namespace Modules\Courses\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Modules\Enrollments\Models\Enrollment;
use Modules\Levels\Models\Level;
use Modules\Students\Models\Student;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

// use Modules\Courses\Database\Factories\CourseFactory;

class Course extends Model implements HasMedia
{

    use InteractsWithMedia;
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function getTranslatedNameAttribute()
    {
        return App::isLocale('ar') ? $this->name_ar : $this->name;
    }

    public function requests()
    {
        return $this->belongsToMany(Student::class, 'course_requests', 'course_id', 'request_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function current_semester_schedule()
    {
        return $this->hasMany(Schedule::class)->whereHas('semester', function ($q) {
            $q->where('is_current', 1);
        });
    }

    public function current_semester_enrollments()
    {
        return $this->hasMany(Enrollment::class)->whereHas('semester', function ($q) {
            $q->where('is_current', 1);
        });
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
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
