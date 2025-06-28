<?php

namespace Modules\Students\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Mail\SendingPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Levels\Models\Level;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class StudentCreate extends Component
{

    use WithFileUploads;

    public UserForm $form;

    #[Validate('bail|required|exists:levels,id')]
    public $level = '';

    #[Validate('bail|nullable|exists:users,id')]
    public $guide = null;

    #[Validate('bail|required|decimal:0,2|min:0.00|max:4.00')]
    public $gpa = 0.00;

    #[Validate('bail|required|integer|min:0|max:180')]
    public $total_earned_credits = 0;


    public $status = false;

    public function store()
    {
        $data = $this->form->validate();
        $password = \Illuminate\Support\Str::password(12);
        $data['password'] = Hash::make($password);
        $data['username'] = $this->form->last_name . '.' . $this->form->first_name . random_int(001, 999);

        if ($this->form->image) {
            $randomName = Str::uuid() . '.' . $this->form->image->getClientOriginalExtension();
            $path = $this->form->image->storeAs('students/profile', $randomName, 'public');
            $data['image'] = $path;
        }

        $student = User::create($data);
        $student->assignRole('student');
        $student->student()->create([
            'guide_id' => $this->guide,
            'level_id' => $this->level,
            'gpa' => $this->gpa,
        ]);


        Mail::to($student->email)->queue((new SendingPassword($data['first_name'] . ' ' . $data['last_name'], $password))->onQueue('emails'));

        $this->form->image = null;
        $this->form->reset();
        $this->reset();

        notyf()->success(__('modules.students.success.store'));

    }

    public function render()
    {
        return view('students::livewire.pages.student-create', [
            'levels' => Level::orderBy('number')->get(),
            'guides' => User::has('professor')->get()->sortBy('full_name'),
        ])->title(__('modules.students.create'));
    }
}
