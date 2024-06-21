<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Application;
use App\Models\ProblemCategory;
use App\Models\Technician;
use App\Models\Ticket;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function getCompany()
    {
        $companies = Company::all();

        // Retourner la vue avec les applications
        return view('admin.companies', compact('companies'));
    }

    public function getTechnicians()
    {
        $technicians = Technician::all();

        return view('admin.technicians', compact('technicians'));
    }

    public function getTickets()
    {
        $companies = Company::all();
        return view('admin.tickets', compact('companies'));
    }

    public function toggleActive(Company $company)
    {
        $company->is_active = !$company->is_active;
        $company->save();

        return redirect()->route('admin.companies');
    }


}
