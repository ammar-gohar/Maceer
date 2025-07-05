<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Enrollments\Models\Enrollment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->hasRole('student'))
        {
            return view('students-profile', [
                'student' => Auth::user(),
                'enrolls' => Enrollment::with(['course', 'semester', 'course.level'])->where('student_id', Auth::id())->get()->groupBy('semester.name'),
            ]);
        };

        if(Auth::user()->hasRole('professor'))
        {
            return view('professors-profile', [
                'professor' => Auth::user(),
            ]);
        };

        if(Auth::user()->hasRole('moderator'))
        {
            return view('moderators-profile', [
                'moderator' => Auth::user(),
            ]);
        };

        return view('home', [
            'professor' => Auth::user(),
        ]);

    }
}
