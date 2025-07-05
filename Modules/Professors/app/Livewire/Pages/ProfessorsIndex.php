<?php

namespace Modules\Professors\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ProfessorsIndex extends Component
{

    use WithPagination;

    public $sortBy = [
        'name',
        'asc'
    ];

    public $search = '';

    public function delete($id)
    {
        User::where('national_id', $id)->firstOrFail()->delete();
    }

    private function filters($query) {

        $query->when($this->search, function ($q) {
            return $q->having('name', 'like', "%$this->search%");
        });

        return $query->orderBy($this->sortBy[0], $this->sortBy[1]);

    }

    public function render()
    {
        $usersQuery = User::query()->has('professor')->select([
                DB::raw('CONCAT_WS(" ", `first_name`, `middle_name`, `last_name`) as name'),
                'national_id',
                'gender',
        ])->join('professors', 'professors.user_id', '=' , 'users.id');
        $users = $this->filters($usersQuery);
        return view('professors::livewire.pages.professors-index', [
            'professors' => $users->paginate(15),
        ])->title(__('sidebar.professors.index'));
    }
}
