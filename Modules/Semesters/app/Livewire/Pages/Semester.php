<?php

namespace Modules\Semesters\Livewire\Pages;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Semesters\Models\Semester as ModelsSemester;

class Semester extends Component
{

    public $name;

    public $start_date;
    public $end_date;

    public function mount() {
        $this->start_date = \Carbon\Carbon::today()->format('Y-m-d');
    }

    public function rules()
    {
        $semester = ModelsSemester::latest()->where('is_current', 0)->first();
        $rule = $semester ? '|after:' . $semester->end_date : '';
        return [
            'name' => 'bail|required|string|unique:semesters',
            'start_date' => 'bail|required|before:end_date' . $rule,
            'end_date' => 'bail|required|after:start_date',
        ];
    }

    public function start_semester()
    {

        $data = $this->validate();

        ModelsSemester::create($data);

        notyf()->success(__('modules.semester.success.start'));
    }

    public function end_semester($id)
    {
        ModelsSemester::find($id)->update([
            'is_current' => 0,
        ]);

        notyf()->success(__('modules.semester.success.end'));
    }

    public function render()
    {
        return view('semesters::livewire.pages.semester', [
            'current' => ModelsSemester::where('is_current', 1)->first(),
        ])->title(__('sidebar.semester'));
    }
}
