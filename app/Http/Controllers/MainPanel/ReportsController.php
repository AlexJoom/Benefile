<?php

namespace App\Http\Controllers\MainPanel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ReportsService;

class ReportsController extends Controller
{
    private $reportsService;

    public function __construct(){
        // only for logged in users
        $this->middleware('auth');
        // initialize reports service
        $this->reportsService = new ReportsService();
    }

    // return reports view with all necessary data
    public function getReports(){
        // count users by roles
        $usersRolesCount = $this->reportsService->getReportDataForUsersRoles();
        // count benefiters by work title
        $benefitersByWorkTitle = $this->reportsService->getReportDataForBenefitersWorkTitle();
        return View('reports.reports')
            ->with('users_roles_count', $usersRolesCount)
            ->with('benefiters_work_title', $benefitersByWorkTitle);
    }
}
