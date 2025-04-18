<?php

namespace Modules\Courses\Livewire;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Modules\Courses\Models\Course;

class CourseList extends Component
{

    public Course $course;
    public $loop;
    public $translatedName;

    public function mount()
    {
        $this->course->translatedName = App::isLocale('ar') ? $this->course->name_ar : $this->course->name;
    }

    public function render()
    {
        return view('courses::livewire.course-list');
    }
}
