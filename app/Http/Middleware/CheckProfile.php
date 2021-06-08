<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Session;

class CheckProfile
{
  /**
   * Handle an incoming request.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    $user = Auth::user();
    if ($user && (empty($user->name) || empty($user->email))) {
      return redirect()->route('account.edit')->with('message', ['type' => 'info', 'message' => 'Please complete your profile']);
    }
    return $next($request);
  }
}
