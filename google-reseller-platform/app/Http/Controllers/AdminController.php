<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\GoogleWorkspaceInstance;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_customers' => Company::count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'pending_provisioning' => GoogleWorkspaceInstance::where('status', 'pending_provisioning')->count(),
            'open_tickets' => SupportTicket::where('status', 'open')->count(),
            'monthly_revenue' => Invoice::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->sum('amount'),
        ];

        $recent_subscriptions = Subscription::with(['company', 'plan'])
            ->latest()
            ->take(5)
            ->get();

        $pending_instances = GoogleWorkspaceInstance::with('company')
            ->where('status', 'pending_provisioning')
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_subscriptions', 'pending_instances'));
    }

    /**
     * Show customer management.
     */
    public function customers()
    {
        $customers = Company::with(['users', 'activeSubscription.plan'])
            ->withCount('users')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.customers', compact('customers'));
    }

    /**
     * Show customer details.
     */
    public function customerDetails(Company $company)
    {
        $company->load(['users', 'subscriptions.plan', 'invoices', 'googleWorkspaceInstance']);
        
        return view('admin.customer-details', compact('company'));
    }

    /**
     * Show provisioning queue.
     */
    public function provisioningQueue()
    {
        $instances = GoogleWorkspaceInstance::with('company')
            ->where('status', 'pending_provisioning')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.provisioning-queue', compact('instances'));
    }

    /**
     * Update Google Workspace instance.
     */
    public function updateInstance(Request $request, GoogleWorkspaceInstance $instance)
    {
        $request->validate([
            'google_customer_id' => 'required|string',
            'status' => 'required|in:active,suspended',
        ]);

        $instance->update([
            'google_customer_id' => $request->google_customer_id,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Google Workspace instance updated successfully.');
    }

    /**
     * Show plan management.
     */
    public function plans()
    {
        $plans = Plan::orderBy('price_monthly', 'asc')->get();
        
        return view('admin.plans', compact('plans'));
    }

    /**
     * Store new plan.
     */
    public function storePlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:plans,slug',
            'price_monthly' => 'required|numeric|min:0',
            'price_annually' => 'required|numeric|min:0',
            'google_workspace_sku' => 'required|string',
            'features' => 'required|array',
        ]);

        Plan::create($request->all());

        return redirect()->route('admin.plans')
            ->with('success', 'Plan created successfully.');
    }

    /**
     * Update plan.
     */
    public function updatePlan(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_monthly' => 'required|numeric|min:0',
            'price_annually' => 'required|numeric|min:0',
            'google_workspace_sku' => 'required|string',
            'features' => 'required|array',
        ]);

        $plan->update($request->all());

        return redirect()->route('admin.plans')
            ->with('success', 'Plan updated successfully.');
    }

    /**
     * Toggle plan status.
     */
    public function togglePlan(Plan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);

        return back()->with('success', 'Plan status updated successfully.');
    }
}
