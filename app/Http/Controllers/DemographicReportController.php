<?php

namespace App\Http\Controllers;

class DemographicReportController extends Controller
{
    public function sex()
    {
        return view('demographic-report', ['type' => 'sex']);
    }

    public function age()
    {
        return view('demographic-report', ['type' => 'age']);
    }

    public function nationality()
    {
        return view('demographic-report', ['type' => 'nationality']);
    }

    public function antique()
    {
        return view('demographic-report', ['type' => 'antique']);
    }

    public function absentism()
    {
        return view('demographic-report', ['type' => 'absentism']);
    }
}
