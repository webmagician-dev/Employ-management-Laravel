<?php

namespace App\Http\Controllers\admin\normal_setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\AdminSetting;

class NormalManagement extends Controller
{
  public function index()
  {
    $normal_setting = AdminSetting::first();
    return view('admin.normal-setting.normal-management', [
      'normal_setting' => $normal_setting,
    ]);
  }

  public function update(Request $request)
  {
    $duration = AdminSetting::first();
    if ($duration === null) {
      $adminsetting = new AdminSetting();
      $adminsetting->suspend_duration = $request->input('suspend_duration');
      $adminsetting->save();
    } else {
      $duration->suspend_duration = $request->input('suspend_duration');
      $duration->save();
    }
  }
}
