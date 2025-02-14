<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('dashboard.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'regex:/^\d{9}$/'],
        ]);
    }

    protected function create(array $data)
    {
        try {
            $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => RolesEnum::Customer->value,
            'phone_number' => $data['phone_number'],
            ]);
            return $user;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Nie udało się utworzyć użytkownika. Proszę spróbować ponownie.');
        }
    }

    public function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();

            $user = $this->create($request->all());

            Auth::login($user);

            return redirect()->route('home')->with('success', 'Rejestracja zakończona sukcesem.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Rejestracja nie powiodła się. Proszę spróbować ponownie.');
        }
    }
}