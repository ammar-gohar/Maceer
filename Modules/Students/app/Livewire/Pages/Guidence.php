<?php

namespace Modules\Students\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Enrollments\Models\Enrollment;
use Modules\Levels\Models\Level;
use Modules\Semesters\Models\Semester;
use Modules\Students\Models\Student;

class Guidence extends Component
{


    public $search = '';
    public $sortBy = ['full_name', 'asc'];
    public $levelFilter = 'all';
    public $guideFilter = 'all';
    public $changeGuideModal = false;
    public $enrollmentsModal = false;
    public $newGuideId = '';
    public $semesterId;

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()->id;
    }

    public function show_modal($studentId, $studentName, $guideId = null)
    {
        $this->changeGuideModal = [
            'id' => $studentId,
            'name' => $studentName,
            'guide' => $guideId ?: null,
        ];
    }

    public function close_modal()
    {
        $this->enrollmentsModal = false;
        $this->changeGuideModal = false;
        $this->newGuideId = '';
    }

    public function change_guide()
    {
        $this->validate([
            'newGuideId' => 'required|exists:users,id',
        ]);

        Student::find($this->changeGuideModal)->update([
            'guide_id' => $this->newGuideId
        ]);
    }

    private function filters($query) {

        $query->when($this->search, function ($q) {
            return $q->where('first_name', 'like', "%$this->search%")
                    ->orWhere('middle_name', 'like', "%$this->search%")
                    ->orWhere('last_name', 'like', "%$this->search%");
        });

        $query->when($this->levelFilter != 'all', function ($q) {
            return $q->whereHas('student', function ($q) {
                $q->where('level_id', $this->levelFilter);
            });
        });

        $query->when($this->guideFilter, function ($q) {
            if ($this->guideFilter == 'all') {
                return $q->whereHas('student', function ($q) {
                    $q->whereNotNull('guide_id');
                });
            } elseif ($this->guideFilter == 'no_guide') {
                return $q->whereHas('student', function ($q) {
                    $q->whereNull('guide_id');
                });
            } else {
                return $q->whereHas('student', function ($q) {
                    $q->where('guide_id', $this->guideFilter);
                });
            }
        });

        return $this->sorting($query->get());

    }

    private function sorting($query)
    {
        switch ($this->sortBy[0]) {
            case 'full_name':
                if($this->sortBy[1] == 'asc') {
                    return $query->sortBy('full_name');
                } else {
                    return $query->sortByDesc('full_name');
                }
                break;
            case 'level':
                if($this->sortBy[1] == 'asc') {
                    return $query->sortBy('student.level.name');
                } else {
                    return $query->sortByDesc('student.level.name');
                }
                break;
            case 'guide':
                if($this->sortBy[1] == 'asc') {
                    return $query->sortBy('student.guide.full_name');
                } else {
                    return $query->sortByDesc('student.guide.full_name');
                }
                break;
            case 'gpa':
                if($this->sortBy[1] == 'asc') {
                    return $query->sortBy('student.gpa');
                } else {
                    return $query->sortByDesc('student.gpa');
                }
                break;
            case 'credits':
                if($this->sortBy[1] == 'asc') {
                    return $query->sortBy('total_earned_credits');
                } else {
                    return $query->sortByDesc('total_earned_credits');
                }
                break;
            default:
                return $query->sortBy('full_name');
        }
    }

    public function remove_guidence($studentId)
    {
        $student = User::find($studentId);

        if ($student && $student->student) {
            $student->student->guide_id = null;
            $student->student->save();
            notyf()->success(__('modules.students.success.guidence_removed'));
        };

    }

    public function approve_enrollments($studentId)
    {
        $semester = Semester::where('is_current', true)->first();

        $enrollments = Enrollment::where('student_id', $studentId)
            ->where('semester_id', $semester->id)
            ->get();

        foreach ($enrollments as $enrollment) {
            $enrollment->update(['approved_at' => now()]);
        }

        notyf()->success(__('modules.students.success.enrollments_approved'));

    }

    public function show_enrollments_modal($studentId, $studentName)
    {
        $student = User::with(['student', 'student.level', 'current_enrollments'])->find($studentId);
        $this->enrollmentsModal = [
            'id' => $studentId,
            'name' => $studentName,
            'level' => $student->student->level->name,
            'gpa' => $student->student->gpa,
            'enrollments' => Enrollment::
                with(['course', 'course.level', 'schedule'])
                ->where('student_id', $studentId)
                ->where('semester_id', Semester::where('is_current', true)->first()->id)
                ->get(),
            'guide' => $student->student->guide ? $student->student->guide->full_name : null,
            'approved_at' => $student->current_enrollments->whereNotNull('approved_at')->pluck('approved_at')->first()
        ];

    }

    public function render()
    {

        $studentsQuery = User::query()
                                ->with(['student.level', 'student.guide'])
                                ->has('student')
                                ->when(!Auth::user()->hasRole('Super Admin'), fn($q) => $q
                                    ->whereHas('student', fn($q) => $q
                                        ->where('guide_id', Auth::id())
                                ));

        $students = $this->filters($studentsQuery);

        return view('students::livewire.pages.guidence', [
            'students' => $students,
            'levels' => Level::select('id', 'name')->get(),
            'guides' => User::has('professor')->get()->sortBy('full_name'),
        ])->title(__('sidebar.students.guidence'));
    }
}
