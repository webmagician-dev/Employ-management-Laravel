<?php

namespace App\Http\Controllers\icons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MdiIcons extends Controller
{
  public function index()
  {
    return view('icons.icons-mdi');
  }
}
