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
use Modules\Students\Models\Student;

class StudentCreate extends Component
{

    use WithFileUploads;

    public UserForm $form;

    #[Validate('bail|nullable|exists:users,id')]
    public $guide = null;

    #[Validate('bail|nullable|image|dimensions:ratio=3/4|max:1024')]
    public $uploadedImage;

    public $status = false;

    public function store()
    {
        $data = $this->form->validate();
        $password = \Illuminate\Support\Str::password(12);
        $data['password'] = Hash::make($password);
        $data['username'] = $this->form->last_name . '.' . $this->form->first_name . random_int(001, 999);

        if ($this->uploadedImage) {
            $randomName = Str::uuid() . '.' . $this->uploadedImage->getClientOriginalExtension();
            $path = $this->uploadedImage->storeAs('students/profile', $randomName, 'public');
            $data['image'] = $path;
        }

        $student = User::create($data);
        $student->assignRole('student');
        $prefix = now()->format('y');
        $student->student()->create([
            'guide_id' => $this->guide,
            'level_id' => Level::where('number', 1)->first()->id,
            'gpa' => 0.0,
            'total_earned_credits' => 0,
            'academic_number' => (integer) $prefix . str_pad(Student::whereBetween('academic_number', [$prefix, (integer) $prefix . '9999'])->count(), '0', STR_PAD_LEFT)
        ]);


        // Mail::to($student->email)->queue((new SendingPassword($data['first_name'] . ' ' . $data['last_name'], $password))->onQueue('emails'));

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("info@maceer.systems", "Maceer admin");
        $email->setSubject();
        $email->addTo($student->email, $data['first_name'] . ' ' . $data['last_name']);
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $sendgrid->send($email);
        } catch (Exception $e) {
            dd('Caught exception: '. $e->getMessage() ."\n");
        }

        $this->uploadedImage = null;
        $this->form->reset();
        $this->reset();

        notyf()->success(__('modules.students.success.store'));

    }

    public function render()
    {
        return view('students::livewire.pages.student-create', [
            'guides' => User::has('professor')->get()->sortBy('full_name'),
        ])->title(__('modules.students.create'));
    }
}
