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

class CourseLibrary extends Component
{
    use WithFileUploads;

    public $course;
    public $code;
    public $semesterId;
    public $file;
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
        'file' => 'required|file|max:10240', // 10MB max
    ];

    public function updatedFile()
    {
        $this->progress = 0;
    }

    public function startUpload()
    {

        $this->validate();

        $now = Carbon::now();
        $path = "courses/$now->year/$now->month";

        $randomFilename = $this->file->getClientOriginalName();

        // Store manually and attach to model
        $storedPath = $this->file->storeAs($path, $randomFilename, 'public');

        $this->course
            ->addMedia(storage_path("app/public/$storedPath"))
            ->preservingOriginal()
            ->usingFileName($randomFilename)
            ->toMediaCollection('course_files');

        $this->reset(['file', 'progress']);

        notyf()->success(__('modules.courses.library.success'));
    }

    public function cancelUpload()
    {
        $this->reset(['file', 'progress']);
    }

    public function download($mediaId)
    {
        $media = $this->course->getMedia('course_files')->where('id', $mediaId)->first();

        if (!$media || !Storage::disk($media->disk)->exists($media->getUrl())) {
            abort(404);
        }

        return response()->download($media->getPath(), $media->file_name);
    }

    public function render()
    {
        return view('courses::livewire.pages.course-library', [
        ]);
    }
}
