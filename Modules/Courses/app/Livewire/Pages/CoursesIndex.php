<?php

namespace Modules\Courses\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Courses\Models\Course;

class CoursesIndex extends Component
{

    use WithPagination;

    public $search = '';
    public $levelFilter;
    public $trashFilter;

    private function filters($query) {

        $query->when($this->search, function ($q) {
            return $q->where('name', 'like', "%$this->search%")
                    ->orWhere('name_ar', 'like', "%$this->search%");
        });

        $query->when($this->levelFilter, function ($q) {
            return $q->where('level', $this->levelFilter);
        });

        $query->when($this->trashFilter, function ($q) {
            if ($this->trashFilter == 'all') {
                return $q->withTrashed();
            } else if ($this->trashFilter == 'trashed') {
                return $q->onlyTrashed();
            } else {
                return $q;
            };
        });
    }

    public function delete($code) {
        Course::where('code', $code)->firstOrFail()->delete();
        notyf()->success('modules.courses.success.delete');
    }

    public function render()
    {

        $coursesQuery = Course::query();

        $this->filters($coursesQuery);

        return view('courses::livewire.pages.courses-index', [
            'courses' => $coursesQuery->orderBy('code')->paginate(15),
        ])->title(__('modules.courses.index'));
    }
}
