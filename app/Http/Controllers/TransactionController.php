<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class TransactionController extends Controller
{
    use SortNSearch;

   function index()
    {
        $perPage = request()->per_page ?? 15;
        $query = Transaction::query();
        $this->applySearchAndSort($query, request());
        return $query->paginate($perPage);
    }

    function create()
    {
        $id = request()->id;
        $fields = ['booking_id','gateway','gateway_response','status','trx_id','user_id'];
        $transaction = $id ? Transaction::findOrFail($id) : new Transaction();
        $this->populate($fields,$transaction);

        $transaction->save();
        return ResponseHelper::success("Transaction Updated", ['item' => $transaction]);
    }

    function destroy()
    {
        $id = request()->id;
        try {
            Transaction::findOrFail($id)->delete();
            return ResponseHelper::success("Transaction Deleted");
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
