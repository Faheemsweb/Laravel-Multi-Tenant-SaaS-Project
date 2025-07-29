<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProvisionTenant;
use App\Models\OnboardingSession;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Rules\NotReserved;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class OnboardingController extends Controller
{
    public function showStep1(Request $request)
    {
        $session = $this->getOnboardingSession($request);
        if ($session && $session->current_step > 1) {
            return $this->redirectToCurrentStep($session);
        }
        return view('onboarding.step1', ['session' => $session]);
    }

    public function storeStep1(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $existsInOnboarding = DB::connection('landlord')
                        ->table('onboarding_sessions')
                        ->where('email', $value)
                        ->exists();
                    $existsInTenants = DB::connection('landlord')
                        ->table('tenants')
                        ->where('email', $value)
                        ->exists();
                    if ($existsInOnboarding || $existsInTenants) {
                        $fail('The email has already been taken.');
                    }
                }
            ],
        ]);

        $session = OnboardingSession::create([
            'token' => Str::uuid(),
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'current_step' => 2,
        ]);

        $request->session()->put('onboarding_token', $session->token);

        return redirect()->route('onboarding.step2.show');
    }

    public function showStep2(Request $request)
    {
        $session = $this->getOnboardingSession($request);
        if (!$session || $session->current_step < 2) return redirect()->route('onboarding.step1.show');
        if ($redirect = $this->redirectToCurrentStep($session)) return $redirect;

        return view('onboarding.step2', ['session' => $session]);
    }

    public function storeStep2(Request $request)
    {
        $session = $this->getOnboardingSession($request);
        if (!$session) return redirect()->route('onboarding.step1.show');

        $data = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $session->update([
            'password' => Hash::make($data['password']),
            'current_step' => 3,
        ]);

        return redirect()->route('onboarding.step3.show');
    }

    public function showStep3(Request $request)
    {
        $session = $this->getOnboardingSession($request);
        if (!$session || $session->current_step < 3) return redirect()->route('onboarding.step1.show');
        if ($redirect = $this->redirectToCurrentStep($session)) return $redirect;

        return view('onboarding.step3', ['session' => $session]);
    }

    public function storeStep3(Request $request)
    {
        $session = $this->getOnboardingSession($request);
        if (!$session) return redirect()->route('onboarding.step1.show');

        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'subdomain' => [
                'required',
                'string',
                'lowercase',
                'alpha_dash',
                'max:50',
                function ($attribute, $value, $fail) use ($session) {
                    $existsInOnboarding = DB::connection('landlord')
                        ->table('onboarding_sessions')
                        ->where('subdomain', $value)
                        ->where('id', '!=', $session->id)
                        ->exists();
                    if ($existsInOnboarding) {
                        $fail('The subdomain has already been taken.');
                    }
                },
                new NotReserved(),
                function ($attribute, $value, $fail) {
                    $domainExists = DB::connection('landlord')
                        ->table('tenants')
                        ->where('domain', 'like', $value . '.%')
                        ->exists();
                    if ($domainExists) {
                        $fail('The subdomain has already been taken.');
                    }
                },
            ],
        ]);

        $session->update([
            'company_name' => $data['company_name'],
            'subdomain' => $data['subdomain'],
            'current_step' => 4,
        ]);

        return redirect()->route('onboarding.step4.show');
    }

    public function showStep4(Request $request)
    {
        $session = $this->getOnboardingSession($request);
        if (!$session || $session->current_step < 4) return redirect()->route('onboarding.step1.show');
        if ($redirect = $this->redirectToCurrentStep($session)) return $redirect;

        return view('onboarding.step4', ['session' => $session]);
    }

    public function storeStep4(Request $request)
    {
        $session = $this->getOnboardingSession($request);
        if (!$session) return redirect()->route('onboarding.step1.show');

        $data = $request->validate([
            'billing_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        $session->update([
            'billing_name' => $data['billing_name'],
            'address' => $data['address'],
            'country' => $data['country'],
            'phone_number' => $data['phone_number'],
            'current_step' => 5,
        ]);

        return redirect()->route('onboarding.step5.show');
    }

    public function showStep5(Request $request)
    {
        $session = $this->getOnboardingSession($request);
        if (!$session || $session->current_step < 5) return redirect()->route('onboarding.step1.show');

        return view('onboarding.step5', ['session' => $session]);
    }

    public function storeStep5(Request $request)
    {
        $session = $this->getOnboardingSession($request);
        if (!$session) return redirect()->route('onboarding.step1.show');

        ProvisionTenant::dispatch($session);

        $request->session()->forget('onboarding_token');

        $domain = $session->subdomain . '.' . config('app.domain');
        return redirect()->route('onboarding.provisioning', ['domain' => $domain]);
    }

    public function provisioning(Request $request)
    {
        return view('onboarding.provisioning', ['domain' => $request->query('domain')]);
    }
    private function getOnboardingSession(Request $request)
    {
        $token = $request->session()->get('onboarding_token');
        if (!$token) {
            return null;
        }

        $session = OnboardingSession::where('token', $token)->first();

        if (!$session) {
            $request->session()->forget('onboarding_token');
            return null;
        }

        if ($session->current_step < 5 && $session->updated_at < Carbon::now()->subMinutes(10)) {
            $session->delete();
            $request->session()->forget('onboarding_token');
            return null;
        }

        return $session;
    }

    private function redirectToCurrentStep(OnboardingSession $session)
    {
        $expectedRoute = route('onboarding.step' . $session->current_step . '.show');
        if ($expectedRoute !== url()->current()) {
            return redirect()->route('onboarding.step' . $session->current_step . '.show');
        }
        return null;
    }
}
