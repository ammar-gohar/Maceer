<?php

namespace Modules\Reports\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Reports\Models\ReportRequest;

class DocumentsCreate extends Component
{

    #[Validate('bail|required|string')]
    public $type = 'transcript';

    #[Validate('bail|nullable|string|max:100')]
    public $concern = '';

    #[Validate('bail|nullable|string')]
    public $notes = '';

    #[Validate('bail|required|in:en,ar')]
    public $language = '';

    #[Validate('bail|required|exists:users,national_id')]
    public $studentId = null;


    public function print()
    {
        $student = User::where('national_id', $this->studentId)->first();
        $request = ReportRequest::create([
            'type' => $this->type,
            'student_id' => $student->id,
            'language' => $this->language,
            'directed_to' => $this->concern,
            'notes' => $this->notes,
            'requested_at' => null,
        ]);

        switch ($request->type) {
            case 'transcript':
                return $this->redirectRoute('reports.transcript', [
                    'id' => $request->id,
                    'lang' => $request->lang,
                ]);
                break;

            case 'registeration_proof':
                # code...
                break;

            case 're-garding':
                # code...
                break;

            default:
                # code...
                break;
        }
    }

    public function render()
    {
        return view('reports::livewire.pages.documents-create',[
            'students' => User::with(['student', 'student.level'])->has('student')->get()->sortBy('student.academic_number'),
        ])->title(__('sidebar.reports.docs_print'));
    }
}
