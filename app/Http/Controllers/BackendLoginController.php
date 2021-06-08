<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Xstudioz\ResponseHelper;
use Auth;
use Symfony\Component\HttpFoundation\Response;

class BackendLoginController extends Controller
{

  public function login(LoginRequest $request)
  {
    $credentials = $request->only(['email', 'password']);
    if (Auth::attempt($credentials)) {
      $user = Auth::user();
      //check if user have role for backend login
      if ($user->hasPermissionTo('backend:login')) {
        return $user;
      } else {
        Auth::logout();
        return ResponseHelper::error(__('You dont have access to perform this action'), [], Response::HTTP_FORBIDDEN);
      }
    }
    return ResponseHelper::error(__("Invalid email & password combination"));
  }

  public function logout()
  {
    Auth::guard('web')->logout();
    return response([]);
  }
}
