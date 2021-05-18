<?php

namespace App\Xstudioz;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use TimeZone\Constants;

trait SortNSearch
{
    function applySearchAndSort(Builder $m, Request $request)
    {
        $trashed = $request->input('trashed', null);
        if ($trashed == 'true') $m->onlyTrashed();
        $search = $request->input('search', null);
        $sort = $request->input('sort', null);
        if ($search) {
            foreach ($search as $k => $v) {

                $init = substr($k, '0', 1);
                switch ($init) {
                    case '#':
                        $filter = str_ireplace('#', '', $k);
                        $m->where($filter, 'LIKE', "%$v%");
                        break;

                    default:
                        if ($k == 'created_at' || $k == 'updated_at') {

                            $dates = array_filter($v);
                            if (count($dates) == 2) {

                                $m->whereBetween($k, $dates);
                            } elseif (count($dates) == 1) {
                                //                        $dates = [Carbon::createFromFormat(Carbon::ISO_FORMAT_REGEXP, $dates[0])->setTimezone(Constants::ASIA_KOLKATA)];
                                $m->whereDate($k, '>=', $dates[0]);
                            }

                        } else if (strpos($k, '.')) {
                            // explode the redaltion
                            $r = explode('.', $k);
                            $m->whereHas($r[0], function ($query) use ($r, $v) {
                                $field = $r[1];
                                if (strpos($field, ':')) {
                                    $slices = explode(':', $field);
                                    $field = $slices[1] . '.' . $slices[0];
                                }

                                $query->where($field, 'LIKE', "%{$v}%");
                            });
                        } else {
                            if ($k && strlen($v) > 0) $m->where($k, 'LIKE', "%{$v}%");
                        }

                }


            }
        }
        if ($sort) {
            if ($sort['key'])
                $m->orderBy($sort['key'], $sort['order']);
            else
                $m->orderBy('id', 'desc');
        }
    }
}
