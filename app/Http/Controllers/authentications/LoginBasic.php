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
    $validator = $request->validate([
      'email' => 'required',
      'password' => 'required',
    ]);

    $user = User::where('email', $request->input('email'))->firstOrFail();

    if (!$user || $user->status === 'suspended') {
      $validator['emailPassword'] = 'Your account is suspended. Please contact support.';
      return redirect('/')->withErrors($validator);
    }

    $user->latest_login = now();
    $user->save();

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      return redirect('/admin/dashboard')->withSuccess('Signed in');
    }
    $validator['emailPassword'] = 'Email address or password is incorrect.';
    return redirect('/')->withErrors($validator);
  }
}
