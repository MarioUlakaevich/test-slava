<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Row;
use Illuminate\Support\Facades\DB;

class RowsController extends Controller
{
    

    public function getRowsGroupedByDate()
    {
        $rows = Row::select(['id', 'name', 'date'])
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('date');

        $result = [];

        foreach ($rows as $date => $records) {
            $result[$date] = $records->toArray();
        }

        return response()->json($result);
    }

}
