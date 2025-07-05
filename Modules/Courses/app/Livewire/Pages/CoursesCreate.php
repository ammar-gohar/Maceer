<?php

namespace Modules\Courses\Livewire\Pages;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Courses\Models\Course;
use Modules\Levels\Models\Level;

class CoursesCreate extends Component
{

    use WithPagination;

    public $status = false;

    #[Validate('bail|required|unique:courses,code')]
    public $code;

    #[Validate('bail|required|unique:courses,name|regex:/[A-z]/')]
    public $name;

    #[Validate('bail|required|unique:courses,name_ar')]
    public $name_ar;

    #[Validate('bail|required|min:0|max:180')]
    public $min_credits = 0;

    #[Validate('bail|required|min:0|max:180')]
    public $credits = 3;

    #[Validate('bail|required|min:0')]
    public $full_mark = 100;

    #[Validate('bail|required|exists:levels,id')]
    public $level = '';

    #[Validate('bail|required|in:university,faculty,specialization')]
    public $requirement = 'specialization';

    #[Validate('bail|required|in:core,elected')]
    public $type = 'core';

    #[Validate('bail|array')]
    public $prerequests = [];

    public string $courseSearch = '';
    public $currentTab = [];

    public function mount()
    {
        if(!$this->currentTab){
            $this->currentTab['show'] = 1;
            $this->currentTab['btn'] = __('forms.add_prerequests');
        }
    }

    public function change_tab()
    {
        if($this->currentTab['show'] == 1) {
            $this->currentTab['show'] = 2;
            $this->currentTab['btn'] = __('forms.back_to_add');
        } else {
            $this->currentTab['show'] = 1;
            $this->currentTab['btn'] = __('forms.add_prerequests');
        }
    }

    public function add_course()
    {

        $course = Course::create([
            'code'        => $this->code,
            'name'        => $this->name,
            'name_ar'     => $this->name_ar,
            'min_credits' => $this->min_credits,
            'credits'     => $this->credits,
            'type'        => $this->type,
            'requirement' => $this->requirement,
            'full_mark'   => $this->full_mark,
            'level_id'    => $this->level,
        ]);

        $course->prerequests()->sync($this->prerequests);

        $this->reset();

        notyf()->success(__('modules.courses.success.create'));
        $this->currentTab['show'] = 1;
        $this->currentTab['btn'] = __('forms.add_prerequests');
    }

    public function add_prerequest($id)
    {
        $this->prerequests[] = $id;
    }

    public function remove_prerequest($id)
    {
        if (($key = array_search($id, $this->prerequests)) !== false) {
            unset($this->prerequests[$key]);
        }
    }

    public function render()
    {
        return view('courses::livewire.pages.courses-create', [
            'courses' => Course::select(['id', 'code', 'name', 'name_ar'])
                                ->whereNotIn('id', $this->prerequests)
                                ->when($this->courseSearch, function($q) {
                                    $q->where('name', 'like', "%$this->courseSearch%")->orWhere('name_ar', 'like', "%$this->courseSearch%")->orWhere('code', 'like', "%$this->courseSearch%");
                                    $this->resetPage();
                                })
                                ->orderBy(App::isLocale('ar') ? 'name_ar' : 'name')
                                ->paginate(7),

            'chosenCourses' => Course::select(['id', 'code', 'name', 'name_ar'])->whereIn('id', $this->prerequests)->orderBy(App::isLocale('ar') ? 'name_ar' : 'name')->get(),
            'levels' => Level::latest()->orderBy('name')->get(),
        ])->title(__('sidebar.courses.create'));
    }
}
