<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
  public function handle(Request $request, Closure $next): Response
  {
    if (Auth::check()) {
      $user = Auth::user();
      if ($user->role == 1) {
        return redirect('/')->withErrors('You do not have access to the admin page.');
      }
    }

    return $next($request);
  }
}
