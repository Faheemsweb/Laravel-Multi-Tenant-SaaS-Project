<?php

namespace App\Jobs;

use App\Models\OnboardingSession;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Jobs\NotTenantAware;

class ProvisionTenant implements ShouldQueue, NotTenantAware
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

 
    public function __construct(public OnboardingSession $session)
    {
    }

    public function handle(): void
    {

        $tenant = Tenant::create([
            'name' => $this->session->company_name,
            'email' => $this->session->email,
            'domain' => $this->session->subdomain . '.' . config('app.domain'),
            'database' => 'myapp_' . $this->session->subdomain,
        ]);

        try {
            DB::connection('landlord')->statement("CREATE DATABASE IF NOT EXISTS `{$tenant->database}`");

            $tenant->makeCurrent();

            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ]);

            Artisan::call('db:seed', [
                '--database' => 'tenant',
                '--class' => 'Database\\Seeders\\TenantSettingsSeeder',
                '--force' => true,
            ]);

            $adminUser = User::where('email', $this->session->email)->first();
            if (!$adminUser) {
                User::create([
                    'name' => $this->session->full_name,
                    'email' => $this->session->email,
                    'password' => $this->session->password,
                ]);
            }

            $tenant->update(['provisioning_status' => 'active']);
            $this->session->delete();

        } catch (Throwable $e) {

            Log::error('ProvisionTenant: Tenant provisioning failed for ' . $tenant->domain . ': ' . $e->getMessage(), [
                'tenant_id' => $tenant->id ?? null,
                'exception' => $e,
            ]);

            try {
                $tenant->update(['provisioning_status' => 'failed']);
            } catch (Throwable $updateEx) {
                Log::warning('ProvisionTenant: Failed to update tenant status to failed: ' . $updateEx->getMessage());
            }

            try {
                DB::connection('landlord')->statement("DROP DATABASE IF EXISTS `{$tenant->database}`");
            } catch (Throwable $dropEx) {
                Log::warning('ProvisionTenant: Failed to drop tenant database: ' . $dropEx->getMessage());
            }

            try {
                $tenant->delete();
            } catch (Throwable $deleteEx) {
                Log::warning('ProvisionTenant: Failed to delete tenant record: ' . $deleteEx->getMessage());
            }

            throw $e;
        } finally {
            Tenant::forgetCurrent();
        }
    }

    /**
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception): void
    {
        Log::critical('ProvisionTenant: Job failed after maximum retries for onboarding session ' . $this->session->id . ': ' . $exception->getMessage(), [
            'exception' => $exception,
            'onboarding_session_id' => $this->session->id,
            'subdomain' => $this->session->subdomain,
        ]);
    }
}
