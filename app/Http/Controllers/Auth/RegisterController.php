<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendingPassword;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'  => ['bail', 'required', 'string', 'max:255', 'regex:/[A-z]/'],
            'middle_name' => ['bail', 'required', 'string', 'max:255', 'regex:/[A-z]/'],
            'last_name'   => ['bail', 'required', 'string', 'max:255', 'regex:/[A-z]/'],
            'national_id' => ['bail', 'required', 'integer', 'digits:14', 'unique:users'],
            'phone'       => ['bail', 'required', 'string', 'digits:11', 'unique:users'],
            'email'       => ['bail', 'required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $password = \Illuminate\Support\Str::password(8);
        $data['password'] = Hash::make($password);

        $user = User::create($data);

        // Mail::to($user->email)->send(new SendingPassword($data['first_name'] . ' ' . $data['last_name'], $password));

        $email = new \SendGrid\Mail\Mail(); 
        $email->setFrom("info@maceer.systems", "Maceer admin");
        $email->setSubject();
        $email->addTo($data['email'], $data['first_name'] . ' ' . $data['last_name']);
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $sendgrid->send($email);
        } catch (Exception $e) {
            dd('Caught exception: '. $e->getMessage() ."\n");
        }

        return $user;

    }
}
