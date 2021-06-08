<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\User;
use App\Xstudioz\ResponseHelper;
use App\Xstudioz\SortNSearch;
use Exception;
use Hash;

class PageController extends Controller
{
  use SortNSearch;

  function index()
  {
    $perPage = request()->per_page ?? 15;
    $query = Page::query();
    $this->applySearchAndSort($query, request());
    return $query->paginate($perPage);
  }

  function create()
  {
    $id = request()->id;
    $fields = ['title', 'slug', 'content', 'banner', 'seo'];
    $page = $id ? Page::findOrFail($id) : new Page();
    $this->populate($fields, $page);

    $page->save();
    return ResponseHelper::success("Page Updated", ['item' => $page]);
  }

  function destroy()
  {
    $id = request()->id;
    try {
      Page::findOrFail($id)->delete();
      return ResponseHelper::success("Page Deleted");
    } catch (Exception $e) {
      return ResponseHelper::error($e->getMessage());
    }
  }
}
