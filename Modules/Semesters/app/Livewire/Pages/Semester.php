<?php

namespace Modules\Semesters\Livewire\Pages;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Semesters\Models\Semester as ModelsSemester;

class Semester extends Component
{

    public $name;

    public $id;
    public $start_date;
    public $end_date;
    public $reqs_start_date;
    public $enrolls_start_date;
    public $enrolls_end_date;

    public function mount() {
        $this->start_date = \Carbon\Carbon::today()->format('Y-m-d');
        $semester = ModelsSemester::latest()->where('is_current', 1)->first();
        if($semester){
            $this->id = $semester->id;
            $this->name = $semester->name;
            $this->start_date = $semester->start_date;
            $this->end_date = $semester->end_date;
            $this->reqs_start_date = $semester->requests_start_date;
            $this->enrolls_start_date = $semester->enrollments_start_date;
            $this->enrolls_end_date = $semester->enrollments_start_date;
        }
    }

    public function rules()
    {
        return [
            'name' => 'bail|required|string|unique:semesters,id,' . $this->id,
            'start_date' => 'bail|required|before:end_date',
            'end_date' => 'bail|required|after:start_date',
            'reqs_start_date' => 'bail|required|before:end_date|after:start_date',
            'enrolls_start_date' => 'bail|required|before:end_date|after:reqs_start_date',
            'enrolls_end_date' => 'bail|required|after:enrolls_start_date|before:end_date',
        ];
    }

    public function start_semester()
    {

        $data = $this->validate();

        ModelsSemester::create($data);

        notyf()->success(__('modules.semester.success.start'));
    }

    public function update_semester()
    {
        $this->validate();

        ModelsSemester::find($this->id)->update([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'requests_start_date' => $this->reqs_start_date,
            'enrollments_start_date' => $this->enrolls_start_date,
            'enrollments_end_date' => $this->enrolls_end_date,
        ]);

        notyf()->success(__('modules.semester.success.update'));

    }

    public function end_semester($id)
    {
        ModelsSemester::find($id)->update([
            'is_current' => 0,
            'end_date' => \Carbon\Carbon::today()->format('Y-m-d'),
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
