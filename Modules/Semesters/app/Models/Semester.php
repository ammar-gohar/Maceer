<?php

namespace Modules\Semesters\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Semesters\Database\Factories\SemesterFactory;

class Semester extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [
    ];

    protected static function newFactory(): SemesterFactory
    {
        return SemesterFactory::new();
    }
}
