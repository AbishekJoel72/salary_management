<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Dashboard(Request $request)
    {
        return view("admin.dashboard");
    }
}
