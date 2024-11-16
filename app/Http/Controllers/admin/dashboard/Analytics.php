<?php

namespace App\Http\Controllers\admin\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

class Analytics extends Controller
{
  public function index()
  {
    return view('admin.dashboard.dashboards-analytics');
  }

  public function signOut()
  {
    Session::flush();
    Auth::logout();

    return Redirect('/');
  }
}
