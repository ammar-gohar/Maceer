<?php

namespace Modules\Reports\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Semesters\Models\Semester;

// use Modules\Reports\Database\Factories\ReceiptFactory;

class Receipt extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    // protected static function newFactory(): ReceiptFactory
    // {
    //     // return ReceiptFactory::new();
    // }
}
