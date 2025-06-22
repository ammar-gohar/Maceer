<?php

namespace Modules\Moderators\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ModeratorsEdit extends Component
{

    use WithFileUploads;

    public UserForm $form;

    public $status = false;

    public function mount(int $national_id)
    {
        $moderator = User::with(['moderator'])->where('national_id', $national_id)->firstOrFail();
        $this->form->fillVars($moderator);
    }

    public function update()
    {
        $data = $this->form->validate();

        $moderator = User::with(['moderator'])->findOrFail($this->form->id);

        if ($this->form->image) {
            if($moderator->image) {
                Storage::disk('public')->delete($moderator->image);
            }
            $randomName = Str::uuid() . '.' . $this->form->image->getClientOriginalExtension();
            $path = $this->form->image->storeAs('profe$moderators/profile', $randomName, 'public');
            $data['image'] = $path;
        }

        $moderator->update($data);

        return $this->redirectRoute('moderators.edit', ['national_id' => $moderator->national_id]);

    }

    public function render()
    {
        return view('moderators::livewire.pages.moderators-edit');
    }
}
