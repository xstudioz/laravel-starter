<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Auth;
use Exception;
use Hash;

class CouponController extends Controller
{
  use SortNSearch;

  function index()
  {
    $perPage = request()->per_page ?? 15;
    $query = Coupon::query();
    $this->applySearchAndSort($query, request());
    return $query->paginate($perPage);
  }

  function create()
  {
    $id = request()->id;
    // set default value
    request()->request->add(['user_id' => Auth::id()]);
    //
    $fields = ['code', 'settings', 'total_used', 'total_uses', 'valid_from', 'valid_to', 'type', 'user_id', 'uses_per_user', 'value'];
    $coupon = $id ? Coupon::findOrFail($id) : new Coupon();
    $this->populate($fields, $coupon);

    $coupon->save();
    return ResponseHelper::success("Coupon Updated", ['item' => $coupon]);
  }

  function destroy()
  {
    $id = request()->id;
    try {
      Coupon::findOrFail($id)->delete();
      return ResponseHelper::success("Coupon Deleted");
    } catch (Exception $e) {
      return ResponseHelper::error($e->getMessage());
    }
  }
}
