<?php

namespace App\Http\Controllers\admin\user_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserInfo;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UserManagement extends Controller
{
  public function index()
  {
    $userlist = UserInfo::all()->map(function ($user) {
      if ($user->user->latest_login) {
        $latestLoginDate = Carbon::parse($user->user->latest_login);
        $user->days_since_last_login = $latestLoginDate->diffInDays(Carbon::now());
      } else {
        $user->days_since_last_login = null;
      }

      return $user;
    });

    return view('admin.user-management.user-management', [
      'userlist' => $userlist,
    ]);
  }

  public function add()
  {
    return view('admin.user-management.user-add');
  }

  public function save(Request $request)
  {
    //Validate the form data
    $request->validate([
      'username' => 'required|string|max:255',
      'email' => 'required|email',
      'password' => 'required|string|min:6|confirmed',
      'phone' => 'required|string',
      'gender' => 'required',
      'address' => 'required|string|max:255',
    ]);

    // Save user data to the database
    $existingUser = User::where('email', $request->input('email'))->first();
    if ($existingUser) {
      return redirect()->route('user-add')->withErrors(['email' => 'Email already exists.']);
    }

    $user = new User();
    $user->name = $request->input('username');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password')); // Hash the password
    $user->phone = $request->input('phone');
    $user->gender = $request->input('gender');
    $user->role = '1';
    $user->status = 'active';
    $user->save();

    $userinfo = new UserInfo();
    $userinfo->user_id = $user->id;
    $userinfo->address = $request->input('address');
    $userinfo->save();
    // Redirect with success message
    return redirect('/admin/setting/user/management')->with('success', 'User created successfully!');
  }

  public function edit($id)
  {
    $user = UserInfo::findOrFail($id);
    return view('admin.user-management.user-edit', ['user' => $user]);
  }

  public function update(Request $request)
  {
    $validatedData = [
      'username' => 'required|string|max:255',
      'phone' => 'nullable|string|max:15',
      'gender' => 'required',
      'address' => 'nullable|string|max:255',
    ];

    // var_dump($request->all());
    // exit;

    if ($request->filled('password')) {
      $validatedData['password'] = 'required|string|min:6|confirmed';
    }

    $request->validate($validatedData);

    // Retrieve the user by ID
    $userinfo = UserInfo::findOrFail($request->input('userid'));
    $user = User::findOrFail($userinfo->user_id);
    $user->name = $request->input('username');
    $user->gender = $request->input('gender');
    $user->phone = $request->input('phone');
    $user->status = $request->input('status');
    // Check if a new password is provided and update it
    if ($request->filled('password')) {
      $user->password = Hash::make($request->input('password'));
    }
    $user->save();

    $userinfo->address = $request->input('address');
    $userinfo->save();

    return redirect('/admin/setting/user/management')->with('success', 'Profile updated successfully!');
  }

  public function destroy($id)
  {
    $userinfo = UserInfo::find($id);

    if ($userinfo) {
      $userinfo->delete();
      $userinfo->user->delete();
      return response()->json(['message' => 'Item deleted successfully.']);
    } else {
      return response()->json(['message' => 'Item not found.'], 404);
    }
  }

  public function permission(Request $request)
  {
    $user = User::find($request->id);
    $user->status = $request->status;
    $user->latest_login = now();
    $user->save();
    return response()->json(['status' => $user->status]);
  }
}
