<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\HasApiTokens;
use Modules\Courses\Models\Course;
use Modules\Enrollments\Models\Enrollment;
use Modules\Professors\Models\Professor;
use Modules\Students\Models\Student;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    use HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function currentSemesterEnrollments()
    {
        return $this->whereHas('enrollments', function ($q) {
            $q
                ->where('year', \Carbon\Carbon::thisYear())
                ->where('semester', 2);
        });
    }

    public function professor(): HasOne
    {
        return $this->hasOne(Professor::class);
    }

    // public function moderator(): HasOne
    // {
    //     return $this->hasOne(Student::class);
    // }

}
