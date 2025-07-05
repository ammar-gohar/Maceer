<?php

namespace Modules\Students\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Levels\Models\Level;

class StudentsIndex extends Component
{

    use WithPagination;

    public $search = '';
    public $sortBy = ['name', 'asc'];
    public $levelFilter = 'all';

    private function filters($query) {

        $query->when($this->levelFilter != 'all', function ($q) {
            $q->whereHas('student', fn($q) => $q
                ->whereHas('level', fn($q) => $q->where('id', $this->levelFilter))
            );
        });


        $query->when($this->search, function ($q) {
            return $q->where('CONCAT_WS(" ", `first_name`, `middle_name`, `last_name`) as name', 'like', "%$this->search%");
        });

        return $this->sorting($query);

    }

    private function sorting($query)
    {
        switch ($this->sortBy[0]) {
            case 'name':
                if($this->sortBy[1] == 'asc') {
                    return $query->orderBy('name');
                } else {
                    return $query->orderByDesc('name');
                }
                break;
            case 'level':
                if($this->sortBy[1] == 'asc') {
                    return $query->orderBy('level');
                } else {
                    return $query->orderByDesc('level');
                }
                break;
            case 'gpa':
                if($this->sortBy[1] == 'asc') {
                    return $query->orderBy('gpa');
                } else {
                    return $query->orderByDesc('gpa');
                }
                break;
            case 'credits':
                if($this->sortBy[1] == 'asc') {
                    return $query->orderBy('total_earned_credits');
                } else {
                    return $query->orderByDesc('total_earned_credits');
                }
                break;
            default:
                return $query->orderBy('name');
        }
    }

    public function delete($id)
    {
        User::where('national_id', $id)->firstOrFail()->delete();
    }

    public function render()
    {

        $usersQuery = User::query()->has('student')->select([
                DB::raw('CONCAT_WS(" ", `first_name`, `middle_name`, `last_name`) as name'),
                'national_id',
                'gender',
                'total_earned_credits',
                'gpa',
                'levels.name as level',
        ])->join('students', 'students.user_id', '=' , 'users.id')->join('levels', 'students.level_id', '=', 'levels.id');
        $users = $this->filters($usersQuery);

        return view('students::livewire.pages.students-index', [
            'students' => $users->paginate(15),
            'levels' => Level::orderBy('number')->get(),
        ])->title(__('sidebar.students.index'));
    }
}
