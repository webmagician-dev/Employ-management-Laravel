<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('authentications.auth-login-basic');
  }

  public function login(Request $request)
  {
    $validatedData = $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    $user = User::where('email', $validatedData['email'])->first();

    if (!$user) {
      return redirect('/')->withErrors(['error' => 'This email is not registered.'])->withInput();
    } 

    if ($user->status === 'suspended') {
      return redirect('/')->withErrors(['email' => 'Your account is suspended. Please contact support.'])->withInput();
    }

    $user->latest_login = now();
    $user->save();

    $credentials = $validatedData;

    if (Auth::attempt($credentials)) {
      return redirect('/admin/dashboard')->withSuccess('Signed in');
    }
    return redirect('/')->withErrors(['error' => 'Email address or password is incorrect.'])->withInput();
  }
}
