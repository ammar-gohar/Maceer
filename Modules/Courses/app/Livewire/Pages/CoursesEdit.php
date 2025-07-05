<?php

namespace Modules\Courses\Livewire\Pages;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Courses\Models\Course;
use Flasher\Notyf\Prime\NotyfInterface;

class CoursesEdit extends Component
{

    use WithPagination;

    public $status = false;

    public $code;
    public $name;
    public $name_ar;
    public $min_credits;
    public $credits;
    public $full_mark;
    public $level;
    public $requirement;
    public $type;
    public $prerequests;

    public string $courseSearch = '';
    public $currentTab = [];


    public Course $course;

    public function mount(string $code)
    {
        $course = Course::with(['prerequests'])->where('code', $code)->firstOrFail();
        $this->course = $course;
        $this->code = $course->code;
        $this->name = $course->name;
        $this->name_ar = $course->name_ar;
        $this->min_credits = $course->min_credits;
        $this->full_mark = $course->full_mark;
        $this->level = $course->level;
        $this->type = $course->type;
        $this->credits = $course->credits;
        $this->prerequests = $course->prerequests->pluck('id')->toArray();
        if(!$this->currentTab){
            $this->currentTab['show'] = 1;
            $this->currentTab['btn'] = __('forms.edit_prerequests');
        }
    }

    public function rules()
    {
        return [
            'code'        => 'bail|required|unique:courses,code,' . $this->course->id,
            'name'        => 'bail|required|unique:courses,name,' . $this->course->id . '|regex:/[A-z]/',
            'name_ar'     => 'bail|required|unique:courses,name_ar,' . $this->course->id,
            'requirement' => 'bail|required|in:university,faculty,specialization',
            'min_credits' => 'bail|required|min:0|max:180',
            'full_mark'   => 'bail|required|min:0',
            'level'       => 'bail|required|in:freshman,junior,sophomore,senior-1,senior-2',
            'prerequests' => 'bail|array',
            'credits'     => 'bail|required|min:0|max:180',
            'type'        => 'bail|required|in:core,elected',
        ];
    }

    public function update_course()
    {

        $this->validate();

        $this->course->update([
            'code'        => $this->code,
            'name'        => $this->name,
            'name_ar'     => $this->name_ar,
            'min_credits' => $this->min_credits,
            'full_mark'   => $this->full_mark,
            'level'       => $this->level,
            'credits'     => $this->credits,
            'type'        => $this->type,
        ]);

        $this->course->prerequests()->sync($this->prerequests);

        notyf()->success(__('modules.courses.success.update'));

    }

    public function change_tab()
    {
        if($this->currentTab['show'] == 1) {
            $this->currentTab['show'] = 2;
            $this->currentTab['btn'] = __('forms.back_to_add');
        } else {
            $this->currentTab['show'] = 1;
            $this->currentTab['btn'] = __('forms.edit_prerequests');
        }
    }

    public function delete()
    {
        $this->course->delete();
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
        return view('courses::livewire.pages.courses-edit', [
            'courses' => Course::select(['id', 'code', 'name', 'name_ar'])
                                ->whereNotIn('id', array_merge($this->prerequests, [$this->course->id]))
                                ->when($this->courseSearch, function($q) {
                                    $this->resetPage();
                                    $q->where('name', 'like', "%$this->courseSearch%")->orWhere('name_ar', 'like', "%$this->courseSearch%")->orWhere('code', 'like', "%$this->courseSearch%");
                                })
                                ->orderBy(App::isLocale('ar') ? 'name_ar' : 'name')
                                ->paginate(7),

            'chosenCourses' => Course::select(['id', 'code', 'name', 'name_ar'])->whereIn('id', $this->prerequests)->orderBy(App::isLocale('ar') ? 'name_ar' : 'name')->get(),
        ])->title((App::isLocale('ar') ? $this->course->name_ar :  $this->course->name) . ' - ' .__('sidebar.courses.edit'));
    }
}
