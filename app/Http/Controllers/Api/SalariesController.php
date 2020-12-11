<?php

namespace App\Http\Controllers\Api;

use App\Models\Salary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalariesController extends Controller
{
    public function index()
    {
        $mainSalary = Salary::mainSalary();
        return response()->json($mainSalary);
    }

    public function store(Request $request)
    {
        $date = Salary::create($request->all());
        return response()->json("Atjaunots!");
    }
}
