<?php

namespace Modules\Professors\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Mail\SendingPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class ProfessorsCreate extends Component
{

    use WithFileUploads;

    public UserForm $form;

    #[Validate('bail|nullable|dimensions:ratio=3/4|max:1024')]
    public $uploadedImage;

    public function store()
    {
        $data = $this->form->validate();
        $password = \Illuminate\Support\Str::password(12);
        $data['password'] = Hash::make($password);
        $data['username'] = $this->form->last_name . '.' . $this->form->first_name . random_int(001, 999);

        if ($this->uploadedImage) {
            $randomName = Str::uuid() . '.' . $this->uploadedImage->getClientOriginalExtension();
            $path = $this->uploadedImage->storeAs('professors/profile', $randomName, 'public');
            $data['image'] = $path;
        }

        $professor = User::create($data);
        $professor->assignRole('professor');
        $professor->professor()->create();

        // Mail::to($professor->email)->queue((new SendingPassword($data['first_name'] . ' ' . $data['last_name'], $password))->onQueue('emails'));

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("info@maceer.systems", "Maceer admin");
        $email->setSubject();
        $email->addTo($professor->email, $data['first_name'] . ' ' . $data['last_name']);
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $sendgrid->send($email);
        } catch (Exception $e) {
            dd('Caught exception: '. $e->getMessage() ."\n");
        }

        notyf()->success(__('modules.professors.success.store'));

        $this->reset();

        return;

    }

    public function reset_inputs()
    {
        return $this->reset();
    }

    public function render()
    {
        return view('professors::livewire.pages.professors-create')->title(__('sidebar.professors.create'));
    }
}
