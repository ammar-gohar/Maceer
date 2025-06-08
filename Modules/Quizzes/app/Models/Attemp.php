<?php

namespace Modules\Quizzes\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Quizzes\Database\Factories\AttempFactory;

class Attemp extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    protected $table = 'attempts';

    // protected static function newFactory(): AttempFactory
    // {
    //     // return AttempFactory::new();
    // }
}
