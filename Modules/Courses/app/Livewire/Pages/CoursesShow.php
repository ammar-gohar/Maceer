<?php

namespace Modules\Courses\Livewire\Pages;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Modules\Courses\Models\Course;

class CoursesShow extends Component
{

    public Course $course;

    public function mount(string $code)
    {
        $this->course = Course::with(['prerequests'])->where('code', $code)->firstOrFail();
    }

    public function render()
    {
        return view('courses::livewire.pages.courses-show')->title(App::isLocale('ar') ? $this->course->name_ar : $this->course->name);
    }
}
