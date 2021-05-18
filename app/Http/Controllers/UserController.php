<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class UserController extends Controller
{
    use SortNSearch;

    function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = User::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = ['email', 'email_verified_at', 'name', 'password', 'phone', 'remember_token', 'status', 'username'];
        $user = $id ? User::findOrFail($id) : new User();
        $this->populate($fields, $user);
        $user->save();
        return ResponseHelper::success("User Updated", ['item' => $user]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            User::findOrFail($id)->delete();
            return ResponseHelper::success("User Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
