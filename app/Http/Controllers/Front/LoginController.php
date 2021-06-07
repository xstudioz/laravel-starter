<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SmsService;
use Auth;
use Str;

class LoginController extends Controller
{
  public function sendOtp()
  {
    $phone = request()->mobile;
    $user = User::wherePhone($phone)->first();
    $otp = 1111;//rand(1000, 9999); //todo enabled
    $otpMessage = "Your OTP for Book Your Own is $otp. SWDM PVT LTD.";
    if ($user) {
      //user is found we send a
      $user->otp = $otp;
      $user->save();
      //SmsService::sendSms($user->phone, $otpMessage);
    } else {
      //we create an account
      $user = new User();
      $user->otp = $otp;
      $user->phone = $phone;
      $user->password = Str::random(8); // todo enable this
      $user->save();
    }
    // SmsService::sendSms($phone, $otpMessage); //todo enable this
    return response([], 201);
  }

  function verifyOtp()
  {
    $phone = request()->mobile;
    $otp = request()->otp;
    $user = User::where(['phone' => $phone, 'otp' => $otp])->first();
    if ($user) {
      Auth::login($user);
      return response()->json($user);
    }

    return response()->json(['message' => 'Invalid mobile & OTP combination'], 404);
  }
}
