<?php

namespace Modules\Reports\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Semesters\Models\Semester;

class ExamSchedule extends Component
{
    use WithFileUploads;

    public $start_date;
    public $end_date;
    public $include_fridays = false;
    public $include_graphs = false;
    public $holidays = [''];
    public $semesterId;
    public $schedules_number;
    public $csv;

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()?->id;

        if(!$this->semesterId)
        {
            return $this->redirect('/semester');
        }
    }

    public function addHoliday()
    {
        $this->holidays[] = '';
    }

    public function removeHoliday($index)
    {
        unset($this->holidays[$index]);
        $this->holidays = array_values($this->holidays); // Reindex array
    }

    public function generate_exam()
    {
        $data = $this->validate([
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'schedules_number' => 'required|integer|min:1',
            'csv'              => 'nullable|mimes:csv',
            'holidays.*'       => 'nullable|date|after_or_equal:start_date|before_or_equal:end_date',
        ]);

        $students = User::with(['current_enrolled_courses'])->has('student')->has('current_enrollments')->get();

        if(!Storage::exists('exam_schedules')){
            Storage::createDirectory('exam_schedules');
        }

        if (!$this->csv) {
            $csv = fopen(Storage::path('exam_schedules/') . Carbon::now()->format('m_Y') . '.csv', 'w');
            foreach ($students as $student) {
                foreach ($student->current_enrolled_courses as $course) {
                    fputcsv($csv, [$student->fullName(), $course->name], ';', '');
                }
            }
            fclose($csv);
            $csv = Storage::path('exam_schedules/') . Carbon::now()->format('m_Y') . '.csv';
        } else {
            $csv = $this->csv;
            $csv = Storage::putFileAs('exam_schedules', $csv, Carbon::now()->format('m_Y') . '.csv');
        };

        $start_date      = $data['start_date'];
        $end_date        = $data['end_date'];
        $holidays        = $data['holidays']; // ARRAY
        $include_fridays = $this->include_fridays; //bool
        $include_graphs  = $this->include_graphs; //bool


        // TO GET THE CSV FILE PATH $csv;
        // =================================================================================
        // =================================================================================
        // NOTE:: To get you need to use foreach loop on ($students as $student) to get the current enrollments of each student
        // ================================================================
        // IN FOREACH LOOP, to get the course name of A STUDENT use: $student->current_enrollments->pluck('course.*.name')
        // ================================================================
        // You can use another foreach loop on ($student->current_enrollments as $course) to get each course of a student. Then you can get the course name as $course->name
        // =================================================================================
        // =================================================================================

        notyf()->success('Exam generated successfully!');
    }

    public function render()
    {
        return view('reports::livewire.exam-schedule');
    }
}
