<?php

namespace Modules\Reports\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Reports\Models\ReportRequest;

class ReportRequests extends Component
{

    #[Validate('bail|required|string')]
    public $type = 'transcript';

    #[Validate('bail|nullable|string|max:100')]
    public $concern = '';

    #[Validate('bail|nullable|string')]
    public $notes = '';

    #[Validate('bail|required|in:en,ar')]
    public $language = '';

    public $typeFilter = '';
    public $fullfillFilter = '';

    public $sortBy = [
        'requested_at',
        'asc',
    ];

    public function delete($id)
    {
        ReportRequest::find($id)->delete();
    }

    public function filtering($query)
    {

        $query->when($this->typeFilter, fn($q) => $q->where('type', $this->typeFilter));

        $query->when($this->fullfillFilter == 'not_fullfilled', fn($q) => $q->whereNull('fullfilled_at'));

        $query->when($this->fullfillFilter == 'fullfilled', fn($q) => $q->whereNotNull('fullfilled_at'));

        return $query->orderBy($this->sortBy[0], $this->sortBy[1]);

    }

    public function add_request()
    {
        ReportRequest::create([
            'type' => $this->type,
            'student_id' => Auth::id(),
            'language' => $this->language,
            'directed_to' => $this->concern,
            'notes' => $this->notes,
            'requested_at' => now(),
        ]);

        return notyf()->success(__('reports.request_sent'));
    }

    public function render()
    {

        $query = ReportRequest::query()->latest()
                                        ->with(['student'])
                                        ->whereNotNull('requested_at')
                                        ->when(Auth::user()->hasPermissionTo('reports.request'), fn($q) => $q->where('student_id', Auth::id()));

        $query = $this->filtering($query);

        return view('reports::livewire.pages.report-requests', [
            'requests' => $query->paginate(15),
        ])->title(__('sidebar.reports.index'));
    }
}
