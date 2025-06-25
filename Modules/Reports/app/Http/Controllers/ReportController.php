<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Enrollments\Models\Enrollment;
use Modules\Semesters\Models\Semester;

class ReportController extends Controller
{

    public function current_enrollment($semesterId, $studentId)
    {

        $semester = Semester::find($semesterId);

        if(!$semester || !$semester->is_current || (Auth::user()->cannot('reports.current_enrollment') && Auth::user()->id !== $studentId)) {
            abort(403);
        }

        $student = User::with(['current_enrollments', 'current_enrollments.course', 'student', 'student.level', 'current_enrollments.course.level'])
            ->findOrFail($studentId);

        return view('reports::current-semester-enrollments', compact('student'));
    }

}
