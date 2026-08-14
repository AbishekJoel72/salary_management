<?php

namespace App\Http\Controllers;

use App\Models\Registration;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function Login(Request $request)
    {

        if ($request->method() == 'POST') {
            if ($request->login_type) {
                try {
                    $validate = $request->validate([
                        'username' => 'required',
                        'password' => 'required',
                    ]);
                    if ($validate) {
                        $user = Registration::where('email', $request->username)->first();
                        if ($user && Hash::check($request->password, $user->password)) {
                            $request->session()->put([
                                'user_id' => $user->id,
                                'user_name' => $user->name,
                                'user_email' => $user->email,
                                'user_phone' => $user->phone,
                                'user_role' => $user->role,
                            ]);

                            if ($user->role == 'admin') {
                                session()->flash('success', 'Admin Login Successfully');

                                return redirect()->route('dashboard');
                            }
                        } else {
                            session()->flash('error', 'Enter the field correctly');

                            return redirect()->back();
                        }
                    }
                } catch (\Exception $e) {
                    session()->flash('error', $e->getMessage());

                    return redirect()->back();
                }
            }
        }

        return view('login.login');
    }

    // public function Register(Request $request)
    // {
    //     return view('login.registration');
    // }
}
