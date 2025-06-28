<?php

namespace Modules\Professors\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Mail\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProfessorsEdit extends Component
{

    use WithFileUploads;

    public UserForm $form;

    #[Validate('bail|nullable|image|max:1024')]
    public $uploadedImage;

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

        if ($this->uploadedImage) {
            if($professor->image) {
                Storage::disk('public')->delete($professor->image);
            }
            $randomName = Str::uuid() . '.' . $this->uploadedImage->getClientOriginalExtension();
            $path = $this->uploadedImage->storeAs('profe$professors/profile', $randomName, 'public');
            $this->form->image = $path;
            $data['image'] = $path;
        }

        $professor->update($data);

        notyf()->success(__('modules.professors.update.success'));

        return $this->redirectRoute('professors.edit', ['national_id' => $professor->national_id]);

    }

    public function reset_password()
    {
        $password = \Illuminate\Support\Str::password(12);
        $hashedPassword = Hash::make($password);

        Mail::to($this->form->email)->queue((new ResetPassword($this->form->first_name . ' ' . $this->form->last_name, $password, now()))->onQueue('emails'));

        User::where('national_id', $this->form->national_id)->first()->update([
            'password' => $hashedPassword,
        ]);

        return notyf()->success(__('forms.reset_password_sent'));
    }

    public function render()
    {
        return view('professors::livewire.pages.professors-edit')->title(__('sidebar.professors.edit'));
    }
}
