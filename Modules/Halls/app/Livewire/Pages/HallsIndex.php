<?php

namespace Modules\Halls\Livewire\Pages;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Halls\Models\Hall;

class HallsIndex extends Component
{

    use WithPagination;

    public $trashFilter;
    public $search = '';

    private function filters($query) {

        $query->when($this->search, function ($q) {
            return $q->where('name', 'like', "%$this->search%");
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

        $this->resetPage();
    }

    public function delete($id) {
        Hall::findOrFail($id)->delete();
        notyf()->success('modules.halls.success.delete');
    }

    public function render()
    {

        $hallsQuery = Hall::query();

        $this->filters($hallsQuery);

        return view('halls::livewire.pages.halls-index', [
            'halls' => $hallsQuery->orderBy('name')->paginate(15),
        ])->title(__('modules.halls.index'));
    }
}
