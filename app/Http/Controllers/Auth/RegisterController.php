<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Session;
use Str;

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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'phone' => ['required', 'string', 'max:16', 'unique:users,phone'],
            'country' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:50'],
            'street' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'country' => $data['country'],
            'city' => $data['city'],
            'street' => $data['street'],
            'status' => 1,
            'password' => Hash::make($data['password']),
        ]);
        if ($data['image']) {
            $file = $data['image'];
            $fileName = Str::slug($user->username) . time() . $file->getClientOriginalExtension();
            //this will save in public disc in storage folder if i not spsify the third prameter as it is the disc name
            //we get files in blade from public folder so i we store the files in storage\app\public we need to make a short cut to this folder in public folder with command storage link
            $path = $file->storeAs('uploads/users', $fileName, ['disk' => 'uploads']);
            $user->update([
                'image' => $fileName //store the path but the right is to store the name
            ]);
        }
        return $user;
    }
    public function register(Request $request)
    {
        // return $request->all();
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);
        // registered to make any condtion i want after logged user as check the status of user an son on or show messge after login
        if ($response = $this->registered($request, $user)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath()); //redirect to / as it is defined in this class
    }
    protected function registered(Request $request, $user)
    {
        Session::flash('success', 'Registerd successfuly');
    }
}
