<?php

namespace Modules\Courses\Livewire\Pages;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Courses\Models\Course;
use Modules\Semesters\Models\Semester;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CourseLibrary extends Component
{
    use WithFileUploads;

    public $course;
    public $code;
    public $semesterId;
    public $files = [];
    public $progress = 0;

    public function mount($code)
    {
        $this->semesterId = Semester::where('is_current', 1)->first()?->id;

        if (!$this->semesterId && Auth::user()->hasPermissionTo('semester')) {
            return $this->redirect('/semester');
        }

        $this->course = Course::with(['media'])->where('code', $code)->first();

        if(Auth::user()->hasRole('professor') && !Auth::user()->current_teaching->contains('course_id', $this->course->id)) {

            return $this->redirect('/courses/professor-courses');

        } else if (Auth::user()->hasRole('student') && !Auth::user()->current_enrolled_courses->contains('course_id', $this->course->id)) {

            return $this->redirect('/courses/student-courses');

        };

    }

    protected $rules = [
        'files.*' => 'file|max:10240', // 10MB per file
    ];

    public function updatedFiles()
    {
        $this->validateOnly('files.*');
        $this->progress = 0;
    }

    public function download($path)
    {
        Storage::download($path);
        return ;
    }



    public function startUpload()
    {
        $this->validate();

        $now = now();
        $path = "courses/{$now->year}/{$now->month}";

        foreach ($this->files as $file) {
            $filename = $file->getClientOriginalName();

            $storedPath = $file->storeAs($path, $filename, 'public');

            $this->course
                ->addMedia(storage_path("app/public/$storedPath"))
                ->preservingOriginal()
                ->usingFileName($filename)
                ->toMediaCollection('course_files');
        }

        $this->reset(['files', 'progress']);
        notyf()->success(__('modules.courses.library.success'));
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files); // re-index the array
    }

    public function render()
    {
        return view('courses::livewire.pages.course-library');
    }
}
