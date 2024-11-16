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
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:6|confirmed',
      'phone' => 'nullable|string|max:15',
      'gender' => 'required',
      'address' => 'nullable|string|max:255',
      'file' => 'nullable|file|mimes:jpg,jpeg,png,gif',
    ]);

    // Process file upload if there is a file
    if ($request->hasFile('file')) {
      $file = $request->file('file');

      if ($file->isValid()) {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('uploads/users', $fileName, 'public');
      } else {
        echo 'Fail';
      }
    }
    // Save user data to the database
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
    $userinfo->avatar = $filePath; // Save the file path
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
    $request->validate([
      'username' => 'required|string|max:255',
      'password' => 'required|string|min:6|confirmed',
      'phone' => 'nullable|string|max:15',
      'gender' => 'required',
      'address' => 'nullable|string|max:255',
      'file' => 'nullable|file|mimes:jpg,jpeg,png,gif',
    ]);

    // Retrieve the user by ID
    $userinfo = UserInfo::findOrFail($request->input('userid'));
    // Update user data
    $userinfo->user->name = $request->input('username');
    $userinfo->user->gender = $request->input('gender');
    $userinfo->user->phone = $request->input('phone');
    // Check if a new password is provided and update it
    if ($request->filled('password')) {
      $userinfo->user->password = Hash::make($request->input('password'));
    }

    if ($request->hasFile('file')) {
      // Delete the old file if it exists
      if ($userinfo->avatar) {
        Storage::disk('public')->delete($userinfo->avatar);
      }

      // Store the new file and update the avatar field
      $filePath = $request->file('file')->store('uploads/users', 'public');
      $userinfo->avatar = $filePath;
    }
    $userinfo->address = $request->input('address');

    // Save the updated user information
    $userinfo->save();

    // Redirect to the user settings page with a success message
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
