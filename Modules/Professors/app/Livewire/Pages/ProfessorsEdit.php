<?php

namespace Modules\Professors\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfessorsEdit extends Component
{

    use WithFileUploads;

    public UserForm $form;

    public $status = false;

    public function mount(int $national_id)
    {
        $professor = User::with(['professor'])->where('national_id', $national_id)->firstOrFail();
        $this->form->fillVars($professor);
    }

    public function update()
    {
        $data = $this->form->validate();

        $professor = User::with(['professor'])->findOrFail($this->form->id);

        if ($this->form->image) {
            if($professor->image) {
                Storage::disk('public')->delete($professor->image);
            }
            $randomName = Str::uuid() . '.' . $this->form->image->getClientOriginalExtension();
            $path = $this->form->image->storeAs('profe$professors/profile', $randomName, 'public');
            $data['image'] = $path;
        }

        $professor->update($data);

        notyf()->success(__('modules.professors.update.success'));

        return $this->redirectRoute('professors.edit', ['national_id' => $professor->national_id]);

    }
    public function render()
    {
        return view('professors::livewire.pages.professors-edit')->title(__('sidebar.professors.edit'));
    }
}
