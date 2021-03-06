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
        $this->middleware('activated');
        // initialize reports service
        $this->reportsService = new ReportsService();
    }

    // return reports view with all necessary data
    public function getReports(){
        /* variables for charts */
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
        // count benefiters based on registration date
        $benefitersCount = $this->reportsService->getReportDataForRegisteredBenefiters();

        return View('reports.reports')
            ->with('users_roles_count', $usersRolesCount)
            ->with('benefitersMaritalStatuses', $benefitersMaritalStatus)
            ->with('benefiters_work_title', $benefitersByWorkTitle)
            ->with('benefiters_age', $benefitersAge)
            ->with('report_benefiters_vs_gender', $report_benefiters_vs_gender)
            ->with('medical_visits_location', $medicalVisitsByLocation)
            ->with('benefiters_legal_statuses', $benefitersLegalStatuses)
            ->with('benefiters_medical_visits', $benefitersPerMedicalVisits)
            ->with('benefiters_count', $benefitersCount)
            ->with('benefiters_medical_visits', $benefitersPerMedicalVisits);
    }
    
    // fetch benefiters vs education data from service in order to be used by an ajax call
    public function getBenefitesVSeducationdata(){
        $report_benefiters_vs_education = $this->reportsService->getReport_benefiters_vs_education();
        return $report_benefiters_vs_education;
    }
    // fetch benefiters vs per doctor distribution data from service in order to be used by an ajax call
    public function getBenefitesVSdoctorsData(){
        $report_benefiters_vs_doctor_type = $this->reportsService->getReport_benefiters_vs_doctor();
        return $report_benefiters_vs_doctor_type;
    }
    // fetch benefiters vs clinical conditions data from service in order to be used by an ajax call
    public function getBenefitesVSClinicalConditionsData(){
        $report_benefiters_vs_clinical_conditions = $this->reportsService->getReport_benefiters_vs_clinical_conditions();
        return $report_benefiters_vs_clinical_conditions;
    }

    //fetch all medical visits destributed per month
    public function getMedicalVisitsVSMonthDate(){
        $report_medical_visits_vs_date = $this->reportsService->getReport_medical_visits_vs_date();
        return $report_medical_visits_vs_date;
    }
    // fetch benefiters vs phycological support type
    public function getBenefitersVSPhycologicalSupportType(){
        $benefiters_vs_phycological_support = $this->reportsService->getReport_benefiters_vs_phycological_support();
        return $benefiters_vs_phycological_support;
    }
    //fetch all Registrations per month
    public function getRegistrationsVSMonthDate(){
        $report_registrations_vs_date = $this->reportsService->getRegistrationsVSMonthDate();
        return $report_registrations_vs_date;
    }

}
