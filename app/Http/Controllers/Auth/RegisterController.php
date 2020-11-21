<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        $data['phone_code'] = $data['phone_code'] ?? null;
        $data['phone_number'] = $data['phone_number'] ?? null;
        $data['phone'] = $data['phone_code'].'-'.$data['phone_number'];

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'phone' => ['required', 'unique:users'],
            'phone_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'numeric'],
            'password' => ['required', 'string','alpha_num', 'min:8', 'confirmed'],
            'image' => ['required','max:5120'],
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
        $data['phone'] = $data['phone_code'].'-'.$data['phone_number'];

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'birthdate' => $data['birthdate'],
            'role' => $data['role'] ?? User::ROLE_USER,
            'image' => $data['image'] ?? '',
        ]);

        /* @var $user User*/

        $imageName = $user->uploadImage($data['image']);
        $user->image = $imageName;
        $user->save();

        return $user;
    }
}
