<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant;

class DashboardController extends Controller
{
    // Show the tenant dashboard with current user and tenant info
    public function index()
    {
        $user = Auth::user();
        $tenant = Tenant::current();

        return view('tenant.dashboard', compact('user', 'tenant'));
    }
}
