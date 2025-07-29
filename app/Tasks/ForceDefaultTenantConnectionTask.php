<?php

namespace App\Tasks;

use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Tasks\SwitchTenantTask;

class ForceDefaultTenantConnectionTask implements SwitchTenantTask
{
    public function makeCurrent(IsTenant $tenant): void
    {
        config(['database.default' => 'tenant']);
    }

    public function forgetCurrent(): void
    {
        config(['database.default' => 'landlord']);
    }
}
