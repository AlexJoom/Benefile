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
        // count benefiters by marital status
        $benefitersMaritalStatus = $this->reportsService->getReportDataForUsersMaritalStatus();
        // count benefiters by work title
        $benefitersByWorkTitle = $this->reportsService->getReportDataForBenefitersWorkTitle();
        // count benefiters by age
        $benefitersAge = $this->reportsService->getReportDataForBenefitersAge();
        // count benefiters by gender
        $report_benefiters_vs_gender = $this->reportsService->getReport_benefiters_vs_gender();
        // count medical visits by location
        $medicalVisitsByLocation = $this->reportsService->getReportDataForMedicalVisitsLocation();
        // count benefiters by legal statuses
        $benefitersLegalStatuses = $this->reportsService->getReportDataForBenefitersLegalStatus();
        // count benefiters per medical visits number
        $benefitersPerMedicalVisits = $this->reportsService->getReportDataForBenefitersPerMedicalVisitsCount();
        return View('reports.reports')
            ->with('users_roles_count', $usersRolesCount)
            ->with('benefitersMaritalStatuses', $benefitersMaritalStatus)
            ->with('benefiters_work_title', $benefitersByWorkTitle)
            ->with('benefiters_age', $benefitersAge)
            ->with('report_benefiters_vs_gender', $report_benefiters_vs_gender)
            ->with('medical_visits_location', $medicalVisitsByLocation)
            ->with('benefiters_legal_statuses', $benefitersLegalStatuses)
            ->with('benefiters_medical_visits', $benefitersPerMedicalVisits);
    }
}
