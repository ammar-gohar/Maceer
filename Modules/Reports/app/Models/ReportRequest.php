<?php

namespace Modules\Reports\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Reports\Database\Factories\ReportRequestFactory;

class ReportRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // protected static function newFactory(): ReportRequestFactory
    // {
    //     // return ReportRequestFactory::new();
    // }
}
