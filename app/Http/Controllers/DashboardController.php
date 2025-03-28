<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', ['type' => 'Index']);
    }

    public function workerLocation()
    {
        return view('dashboard', ['type' => 'WorkerLocation']);
    }

    public function typography()
    {
        return view('dashboard', ['type' => 'Typography']);
    }
}
