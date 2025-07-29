<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LandlordLoginRequest;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        return view('landlord.tenants.index', compact('tenants'));
    }

    public function showLoginForm(): View
    {
        return view('landlord.auth.login');
    }

    public function login(LandlordLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('landlord')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function updateStatus(Request $request, Tenant $tenant)
    {
        $request->validate([
            'status' => 'required|string|in:active,suspended',
        ]);

        $tenant->provisioning_status = $request->input('status');
        $tenant->save();

        return back()->with('success', "Tenant status has been updated.");
    }

    public function destroy(Tenant $tenant)
    {
        try {
            $databaseName = $tenant->database;

            DB::statement("DROP DATABASE IF EXISTS `{$databaseName}`");

            $tenantId = $tenant->id;

            $tenant->delete();

            Tenant::forgetById($tenantId);

            return back()->with('success', "Tenant '{$databaseName}' and all its data have been permanently deleted.");

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while deleting the tenant: ' . $e->getMessage());
        }
    }
}
