<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\Courses\Models\Schedule;
use Modules\Enrollments\Models\Enrollment;
use Modules\Reports\Models\Receipt;
use Modules\Reports\Models\ReportRequest;
use Modules\Semesters\Models\Semester;

class ReportController extends Controller
{

    public function current_enrollment($semesterId, $studentId)
    {

        $semester = Semester::find($semesterId);

        if(!$semester || !$semester->is_current || (Auth::user()->cannot('reports.current_enrollment') && Auth::user()->id !== $studentId)) {
            return abort(403);
        }

        $student = User::with(['current_enrollments', 'current_enrollments.course', 'student', 'student.level', 'current_enrollments.course.level'])
            ->findOrFail($studentId);

        if($student->current_enrollments->count() == 0){
            return abort(403);
        }

        $receipt = Receipt::where('student_id', $studentId)->where('semester_id', $semester)->first();

        return view('reports::current-semester-enrollments', compact('student', 'semester', $receipt));
    }

    public function enrollments($studentId)
    {

        if((Auth::user()->cannot('reports.enrollment') && Auth::user()->id !== $studentId)) {
            abort(403);
        }

        $student = User::with(['enrollments' => fn($q) => $q->orderBy('created_at'), 'enrollments.course', 'student', 'student.level', 'enrollments.course.level'])
            ->find($studentId);

        return view('reports::all-enrollments', compact('student'));
    }

    public function transcript($id, $lang = null)
    {
        $transcript = ReportRequest::find($id);
        $student = User::with(['student', 'student.level'])->find($transcript->student_id);
        $enrollments = Enrollment::with(['course', 'grade', 'semester'])->where('student_id', $student->id)->get()->groupBy('semester.name')->sortBy('semester.created_at');

        $lang = $lang ?: App::getLocale();

        return view('reports::transcript', [
            'transcript' => $transcript,
            'student' => $student,
            'enrollments' => $enrollments,
            'lang' => $lang,
        ]);
    }

    public function receipt($studentId)
    {
        return view('reports::transcript', [
            'student' => User::with('student')->find($studentId),
        ]);
    }

    public function schedule_list($scheduleId)
    {
        $schedule = Schedule::find($scheduleId);


    }

    public function course_students($scheduleId, $lang = null)
    {
        $enrollments = Enrollment::with(['student', 'student.student', 'course'])->where('schedule_id', $scheduleId)->get()->sortBy('student.full_name');
        $semester = Semester::where('is_current', 1)->first();

        $lang = $lang ?: App::getLocale();

        return view('reports::course-students', [
            'enrollments' => $enrollments,
            'semester' => $semester,
            'lang' => $lang,
        ]);
    }
}
