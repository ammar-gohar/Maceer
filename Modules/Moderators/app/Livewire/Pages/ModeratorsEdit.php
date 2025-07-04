<?php

namespace Modules\Moderators\Livewire\Pages;

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

class ModeratorsEdit extends Component
{

    use WithFileUploads;

    public UserForm $form;

    #[Validate('bail|nullable|image|dimensions:ratio=3/4|max:1024')]
    public $uploadedImage;

    public function mount(int $national_id)
    {
        $moderator = User::with(['moderator'])->where('national_id', $national_id)->firstOrFail();
        $this->form->fillVars($moderator);
    }

    public function update()
    {
        $data = $this->form->validate();

        $moderator = User::with(['moderator'])->findOrFail($this->form->id);

        if ($this->uploadedImage) {
            if($moderator->image) {
                Storage::disk('public')->delete($moderator->image);
            }
            $randomName = Str::uuid() . '.' . $this->uploadedImage->getClientOriginalExtension();
            $path = $this->uploadedImage->storeAs('moderators/profile', $randomName, 'public');
            $data['image'] = $path;
        }

        $moderator->update($data);
        notyf()->success(__('modules.moderators.success.update'));

        return $this->redirectRoute('moderators.edit', ['national_id' => $moderator->national_id]);

    }

    public function reset_password()
    {
        $password = \Illuminate\Support\Str::password(12);
        $hashedPassword = Hash::make($password);

        // Mail::to($this->form->email)->queue((new ResetPassword($this->form->first_name . ' ' . $this->form->last_name, $password, now()))->onQueue('emails'));

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("info@maceer.systems", "Maceer admin");
        $email->setSubject("New user password");
        $email->addTo($this->form->email, $this->form->first_name . ' ' . $this->form->last_name);
        $email->addContent(
            "text/html", "here is your password <strong> $password </strong>"
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $sendgrid->send($email);
        } catch (Exception $e) {
            dd('Caught exception: '. $e->getMessage() ."\n");
        }

        User::where('national_id', $this->form->national_id)->first()->update([
            'password' => $hashedPassword,
        ]);

        return notyf()->success(__('forms.reset_password_sent'));
    }

    public function render()
    {
        return view('moderators::livewire.pages.moderators-edit');
    }
}
