<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingSession extends Model
{
    use HasFactory;

    // Allow mass assignment
    protected $guarded = [];

    /**
     * Determine if the session is ready for provisioning.
     *
     * @return bool
     */
    public function isReadyForProvisioning(): bool
    {
        return !empty($this->plan)
            && !empty($this->company_name)
            && !empty($this->domain)
            && !empty($this->name)
            && !empty($this->email)
            && !empty($this->password);
    }
}
