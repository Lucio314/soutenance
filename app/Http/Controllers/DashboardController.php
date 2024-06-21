<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboardRedirect() {
        if (Auth::user()->role == 'technician') {
            return redirect()->route('technicians.dashboard');
        }elseif (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('companies.dashboard');
    }
}
