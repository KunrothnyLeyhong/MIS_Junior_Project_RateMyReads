<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AllReportController extends Controller
{
    public function allreport()
    {
        return view('report.allreport');
    }
}
