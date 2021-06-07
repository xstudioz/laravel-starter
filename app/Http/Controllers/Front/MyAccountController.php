<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Booking;
use App\Models\UserMeta;
use App\Repositories\UserRepository;
use Auth;
use Illuminate\Http\RedirectResponse;
use Session;

class MyAccountController extends Controller
{
  function editProfile()
  {
    $title = 'My Account';
    $user = Auth::user();
    $metas['address'] = UserMeta::getValue('address', $user->id);
    return view('pages.account.profile', compact('title', 'user', 'metas'));
  }

  function updateProfile(UpdateProfileRequest $request): RedirectResponse
  {
    $user = Auth::user();
    $user->email = $request->email;
    $user->name = $request->name;
    foreach ($request->metas as $k => $v) {
      $user->metas()->where(['meta_key' => $k])->delete();
      $user->metas()->create(['meta_key' => $k, 'meta_value' => $v]);
    }
    $user->save();
    return redirect()->back()->with('message', ['type' => 'success', 'message' => 'Profile Updated']);
  }

  function bookings(UserRepository $userRepository)
  {
    $title = "My Bookings";
    $bookings = $userRepository->bookings(Auth::id());
    return view('pages.account.bookings', compact('title', 'bookings'));


  }

  function logout()
  {
    Auth::guard('web')->logout();
    Session::flash('message', ['type' => 'success', 'message' => 'You have been logged out']);
    return redirect()->route('home');
  }

  function viewBooking($guid)
  {
    $title = "My Bookings";
    $booking = Booking::whereUserId(Auth::id())->whereGuid($guid)->first();
    return view('pages.account.booking', compact('title', 'booking'));
  }


  function reviews() { }
}
