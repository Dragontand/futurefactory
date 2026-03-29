<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get modules, pagianate and give with view
        return view('dashboard');
    }
}
