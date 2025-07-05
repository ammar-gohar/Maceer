<?php

namespace Modules\Reports\Livewire\Pages;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Reports\Models\Receipt;
use Modules\Semesters\Models\Semester;
use Modules\Students\Models\Student;

class Receipts extends Component
{

    public $semesterId;
    public $search = '';
    public $toRegister = null;

    #[Validate('bail|required|integer|unique:receipts,receipt_number')]
    public $receipt_number;

    #[Validate('bail|required|date')]
    public $paied_at;

    public function mount()
    {
        $this->semesterId = Semester::where('is_current', 1)->first()->id;
    }

    public function open_to_register(string $id)
    {
        $this->toRegister = Receipt::with(['student', 'student.student', 'student.student.level'])->find($id);
    }

    public function cancel_registeration(string $id)
    {
        $receipt = Receipt::find($id);
        $receipt->update([
            'paied_at' => null,
            'receipt_number' => null,
        ]);
        return notyf()->success(__('modules.reports.receipt_canceled'));
    }

    public function register_receipt()
    {
        $this->toRegister->update([
            'paied_at' => $this->paied_at,
            'receipt_number' => $this->receipt_number,
        ]);

        $this->toRegister = null;
        $this->paied_at = '';
        $this->receipt_number = '';

        return notyf()->success(__('modules.reports.receipt_registered'));
    }

    public function render()
    {
        return view('reports::livewire.pages.receipts', [
            'receipts' => Receipt::with(['student', 'student.student', 'student.student.level'])
                                ->where('semester_id', $this->semesterId)
                                ->whereHas('student', fn($q) => $q
                                    ->whereHas('student', fn($q) => $q
                                        ->where('academic_number', 'like', "$this->search%")
                                    )
                                    ->orWhereRaw(
                                        "CONCAT_WS(' ', first_name, last_name) LIKE ?",
                                        ['%' . $this->search . '%']
                                    )
                                )
                                ->when(!$this->search, fn($q) => $q->take(0))
                                ->get(),
        ])->title(__('sidebar.reports.receipt_register'));
    }
}
