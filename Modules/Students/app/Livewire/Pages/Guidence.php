<?php

namespace Modules\Students\Livewire\Pages;

use App\Jobs\AssignGuidence;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Enrollments\Models\Enrollment;
use Modules\Levels\Models\Level;
use Modules\Professors\Models\Professor;
use Modules\Semesters\Models\Semester;
use Modules\Students\Models\Student;

class Guidence extends Component
{


    public $search = '';
    public $sortBy = ['name', 'asc'];
    public $levelFilter = 'all';
    public $guideFilter = 'all';
    public $changeGuideModal = false;
    public $enrollmentsModal = false;
    public $newGuideId = '';
    public $semesterId;
    public $guidesModal = [];

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()->id;
    }

    public function updatedGuidesModal()
    {
        $this->showGuidesModal($this->guidesModal['search']);
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
        $this->guidesModal = false;
        $this->newGuideId = '';
    }

    public function change_guide()
    {
        $this->validate([
            'newGuideId' => 'required|exists:users,id',
        ]);

        Student::where('id', $this->changeGuideModal)->update([
            'guide_id' => $this->newGuideId
        ]);
    }

    private function filters($query) {

        $query->when($this->search, function ($q) {
            return $q->having('name', 'like', "%$this->search%")
                    ->orHaving('guide_name', 'like', "%$this->search%")
                    ->orHaving('academic_number', 'like', "$this->search%");
        });

        $query->when($this->levelFilter != 'all', function ($q) {
            return $q->whereHas('student', function ($q) {
                $q->where('level_id', $this->levelFilter);
            });
        });

        $query->when($this->guideFilter, function ($q) {
            if ($this->guideFilter == 'all') {
                return $q;
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

        return $query->orderBy($this->sortBy[0], $this->sortBy[1]);

    }

    public function remove_guidence($studentId)
    {
        $student = Student::find($studentId);

        $student->update([
            'guide_id' => null,
        ]);

        notyf()->success(__('modules.students.success.guidence_removed'));

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
            'level' => $student->student?->level?->name,
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

    public function showGuidesModal($search = '')
    {
        $this->guidesModal = [
            'search' => $search,
            'guides' => User::withCount('guidence')
                            ->with(['professor'])
                            ->whereHas('professor', fn($q) => $q->where('is_guide', 1))->get()->sortBy('full_name'),
        ];

        $professors = User::with(['professor'])
                            ->whereHas('professor', fn($q) => $q->where('is_guide', 0))
                            ->when($this->guidesModal['search'], fn($q) => $q
                                ->whereRaw(
                                    "CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?",
                                    ['%' . $search . '%']
                                )
                            )
                            ->get()
                            ->sortBy('full_name');

        $this->guidesModal['other_professors'] = $professors;

        debugbar()->info($this->guidesModal);

        return;
    }

    public function add_guide($id)
    {
        Professor::find($id)->update(['is_guide' => 1]);
        $this->showGuidesModal($this->guidesModal['search']);
    }

    public function remove_guide($id)
    {
        Professor::find($id)->update(['is_guide' => 0]);
        $this->showGuidesModal($this->guidesModal['search']);
    }

    public function guide_students()
    {

        Student::chunkById(50, function ($chunk) {
            $guides = User::withCount('guidence')->whereHas('professor', fn($q) => $q->where('is_guide', 1))->orderBy('guidence_count', 'asc')->get();
            $updates = [];
            foreach ($chunk as $student)
            {
                $guide = $guides->sortBy('guidence_count')->first();
                $updates[$guide->id][] = $student->id;
                $guide->guidence_count++;
            };

            foreach ($updates as $guideId => $studentIds) {
                Student::whereIn('id', $studentIds)->update([
                    'guide_id' => $guideId,
                ]);
            };

        });

        $this->showGuidesModal($this->guidesModal['search']);

        return notyf()->success(__('modules.professors.guide_students_success'));

    }

    public function render()
    {

        $usersQuery = User::query()->has('student')
        ->when(Auth::user()->hasRole('professor'), fn($q) => $q
            ->whereHas('student', fn($q) => $q->where('guide_id', Auth::id()))
        )
        ->select([
            DB::raw('CONCAT_WS(" ", users.`first_name`, users.`middle_name`, users.`last_name`) as name'),
            DB::raw('CONCAT_WS(" ", guides.`first_name`, guides.`last_name`) as guide_name'),
            'users.national_id',
            'academic_number',
            'users.gender as gender',
            'students.id as student_id',
            'students.guide_id as guide_id',
            'total_earned_credits as credits',
            'gpa',
            'levels.name as level',
            'paied_at as receipt_paied_at',
        ])
        ->leftJoin('students', 'students.user_id', '=' , 'users.id')
        ->leftJoin('levels', 'students.level_id', '=', 'levels.id')
        ->leftJoin('users as guides', 'students.guide_id', '=', 'guides.id')
        ->leftJoin('receipts', fn($q) => $q
            ->on('users.id', '=', 'receipts.student_id')
            ->where('receipts.semester_id', '=', $this->semesterId)
        );
        $users = $this->filters($usersQuery);

        return view('students::livewire.pages.guidence', [
            'students' => $users->paginate(15),
            'levels' => Level::select('id', 'name')->get(),
            'guides' => User::whereHas('professor', fn($q) => $q->where('is_guide', 1))->get()->sortBy('full_name'),
        ])->title(__('sidebar.students.guidence'));
    }
}
