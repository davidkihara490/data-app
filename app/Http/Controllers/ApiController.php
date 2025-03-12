<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ApiController extends Controller
{
    public function fetchData($template)
    {
        if (Schema::hasTable($template)) {
            $data = DB::table($template)->paginate(10);
            return response()->json($data);
        } else {
            return response()->json(['error' => 'The data does not exists.']);
        }
    }
}
