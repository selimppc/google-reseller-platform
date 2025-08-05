<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleWorkspaceInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'google_customer_id',
        'domain_name',
        'status',
    ];

    /**
     * Get the company that owns the Google Workspace instance.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Check if instance is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if instance is pending provisioning.
     */
    public function isPendingProvisioning(): bool
    {
        return $this->status === 'pending_provisioning';
    }

    /**
     * Check if instance is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }
}
