<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $dates = [
            'today' => date("Y.m.d"),
        ];
        return view('home.index', compact('dates'));
    }
}
