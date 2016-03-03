<?php

namespace App\Http\Controllers\MainPanel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function __construct(){
        // only for logged in users
        $this->middleware('auth');
    }

    public function getReports(){
        return View('userPanel.reports');
    }
}
