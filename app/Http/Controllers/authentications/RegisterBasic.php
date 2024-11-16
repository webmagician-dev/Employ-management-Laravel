<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterBasic extends Controller
{
  public function index()
  {
    return view('authentications.auth-register-basic');
  }

  public function register(Request $request)
  {
    $request->validate([
      'username' => 'required',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6',
      'gender' => 'required',
      'phone' => 'required',
    ]);
    $user = $this->create($request->all());

    Auth::login($user);

    UserInfo::create([
      'user_id' => $user->id,
      'avatar' => '',
      'address' => '',
    ]);

    return redirect('/admin/dashboard')->withSuccess('You have signed-in');
  }

  public function create(array $data)
  {
    return User::create([
      'name' => $data['username'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
      'role' => '1',
      'gender' => $data['gender'],
      'phone' => $data['phone'],
      'latest_login' => now(),
      'status' => 'active',
    ]);
  }
}
