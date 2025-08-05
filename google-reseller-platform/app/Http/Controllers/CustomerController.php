<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $company = $user->company;
        
        return view('customer.dashboard', compact('user', 'company'));
    }

    /**
     * Show billing history.
     */
    public function billingHistory()
    {
        $user = auth()->user();
        $invoices = $user->company->invoices()->with('subscription.plan')->orderBy('created_at', 'desc')->get();
        
        return view('customer.billing-history', compact('invoices'));
    }

    /**
     * Download invoice as PDF.
     */
    public function downloadInvoice(Invoice $invoice)
    {
        // Check if user has access to this invoice
        if ($invoice->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $pdf = \PDF::loadView('pdfs.invoice', compact('invoice'));
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }

    /**
     * Show subscription management.
     */
    public function subscription()
    {
        $user = auth()->user();
        $subscription = $user->company->activeSubscription;
        
        return view('customer.subscription', compact('subscription'));
    }

    /**
     * Cancel subscription.
     */
    public function cancelSubscription(Request $request)
    {
        $user = auth()->user();
        $subscription = $user->company->activeSubscription;

        if ($subscription) {
            $subscription->update(['status' => 'cancelled']);
            
            return redirect()->route('customer.subscription')
                ->with('success', 'Your subscription has been cancelled.');
        }

        return redirect()->route('customer.subscription')
            ->with('error', 'No active subscription found.');
    }
}
