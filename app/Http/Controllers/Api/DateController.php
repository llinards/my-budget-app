<?php

namespace App\Http\Controllers\Api;

use App\Models\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DateController extends Controller
{
    public function index()
    {
        $date = Date::latest('created_at')->first();
        return response()->json($date);
    }

    public function store(Request $request)
    {
        $date = Date::create($request->all());
        return response()->json("Atjaunots!");
    }
}
