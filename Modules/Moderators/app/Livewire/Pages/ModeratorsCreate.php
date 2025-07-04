<?php

namespace Modules\Moderators\Livewire\Pages;

use App\Livewire\Forms\UserForm;
use App\Mail\SendingPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class ModeratorsCreate extends Component
{

    use WithFileUploads;

    public UserForm $form;

    #[Validate('bail|nullable|image|dimensions:ratio=3/4|max:1024')]
    public $uploadedImage;

    public function store()
    {
        $data = $this->form->validate();
        $password = \Illuminate\Support\Str::password(12);
        $data['password'] = Hash::make($password);
        $data['username'] = $this->form->last_name . '.' . $this->form->first_name . random_int(001, 999);

        if ($this->uploadedImage) {
            $randomName = Str::uuid() . '.' . $this->uploadedImage->getClientOriginalExtension();
            $path = $this->uploadedImage->storeAs('moderators/profile', $randomName, 'public');
            $data['image'] = $path;
        }

        $moderator = User::create($data);
        $moderator->assignRole('staff');
        $moderator->moderator()->create();

        // Mail::to($moderator->email)->queue((new SendingPassword($data['first_name'] . ' ' . $data['last_name'], $password))->onQueue('emails'));

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("info@maceer.systems", "Maceer admin");
        $email->setSubject("New user password");
        $email->addTo($moderator->email, $data['first_name'] . ' ' . $data['last_name']);
        $email->addContent(
            "text/html", "here is your password <strong> $password </strong>"
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $sendgrid->send($email);
        } catch (Exception $e) {
            dd('Caught exception: '. $e->getMessage() ."\n");
        }

        notyf()->success(__('modules.moderators.success.store'));

        $this->reset();

    }

    public function render()
    {
        return view('moderators::livewire.pages.moderators-create')
                ->title(__('sidebar.moderators.create'));
    }
}
