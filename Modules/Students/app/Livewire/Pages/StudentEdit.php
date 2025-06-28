<?php

namespace Modules\Students\Livewire\Pages;

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
use Modules\Levels\Models\Level;

class StudentEdit extends Component
{

    use WithFileUploads;

    public UserForm $form;

    #[Validate('bail|nullable|exists:users,id')]
    public $guide = null;

    #[Validate('bail|required|exists:levels,id')]
    public $level;

    #[Validate('bail|required|decimal:1,2|min:0.00|max:4.00')]
    public $gpa;

    #[Validate('bail|required|integer|min:0|max:180')]
    public $total_earned_credits;
    
    #[Validate('bail|nullable|image|max:1024')]
    public $uploadedImage;

    public $status = false;

    public function mount(int $national_id)
    {
        $student = User::with(['student'])->where('national_id', $national_id)->firstOrFail();
        $this->level = $student->student->level_id;
        $this->guide = $student->student->guide_id;
        $this->gpa = $student->student->gpa;
        $this->total_earned_credits = $student->student->total_earned_credits;
        $this->form->fillVars($student);
    }

    public function update()
    {
        $data = $this->form->validate();

        $student = User::with(['student'])->findOrFail($this->form->id);

        if ($this->uploadedImage) {
            if($student->image) {
                Storage::disk('public')->delete($student->image);
            }
            $randomName = Str::uuid() . '.' . $this->uploadedImage->getClientOriginalExtension();
            $path = $this->uploadedImage->storeAs('students/profile', $randomName, 'public');
            $data['image'] = $path;
            $this->uploadedImage = $data['image'];
        }

        $student->update($data);
        $student->student()->update([
            'guide_id' => $this->guide,
            'level_id' => $this->level,
            'gpa' => $this->gpa,
            'total_earned_credits' => $this->total_earned_credits,
        ]);

        notyf()->success(__('modules.students.success.update'));

        return $this->redirectRoute('students.edit', ['national_id' => $student->national_id]);


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
        return view('students::livewire.pages.student-edit', [
            'levels' => Level::orderBy('number')->get(),
            'guides' => User::has('professor')->get()->sortBy('full_name'),
        ])->title(__('modules.students.edit'));
    }
}
