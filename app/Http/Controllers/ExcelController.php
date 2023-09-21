<?php

namespace App\Http\Controllers;

use App\Jobs\ExcelJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExcelController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        
        ExcelJob::dispatch($request->file('file')->path());
        
        return response()->json(['message' => 'File uploaded and processing started.']);
    }

}
