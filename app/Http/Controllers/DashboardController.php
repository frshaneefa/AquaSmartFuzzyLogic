<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // You can customize this method as needed.
        return view('dashboard1'); // Assuming you have a dashboard.blade.php file.
    }
}
