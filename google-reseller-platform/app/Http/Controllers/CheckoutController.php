<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show the checkout form.
     */
    public function show(Request $request)
    {
        $plan = Plan::where('slug', $request->plan)->firstOrFail();
        return view('checkout', compact('plan'));
    }

    /**
     * Process the checkout and create subscription.
     */
    public function process(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'company_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'billing_cycle' => 'required|in:monthly,annually',
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        DB::beginTransaction();

        try {
            // Create company
            $company = Company::create([
                'name' => $request->company_name,
                'contact_email' => $request->email,
                'contact_phone' => $request->contact_phone,
                'billing_address' => $request->billing_address,
            ]);

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
                'company_id' => $company->id,
            ]);

            // Create subscription
            $subscription = Subscription::create([
                'company_id' => $company->id,
                'plan_id' => $plan->id,
                'status' => 'trial',
                'trial_ends_at' => now()->addDays(14),
                'billing_cycle' => $request->billing_cycle,
                'next_payment_date' => now()->addDays(14),
            ]);

            // Create initial invoice
            $amount = $plan->getPrice($request->billing_cycle);
            $invoice = Invoice::create([
                'subscription_id' => $subscription->id,
                'company_id' => $company->id,
                'amount' => $amount,
                'status' => 'pending',
                'due_date' => now()->addDays(14),
                'invoice_number' => Invoice::generateInvoiceNumber(),
            ]);

            DB::commit();

            // Log in the user
            auth()->login($user);

            // Redirect to payment gateway (SSLCOMMERZ)
            return $this->redirectToPaymentGateway($invoice);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred during checkout. Please try again.']);
        }
    }

    /**
     * Redirect to payment gateway.
     */
    private function redirectToPaymentGateway(Invoice $invoice)
    {
        // In a real application, you would integrate with SSLCOMMERZ here
        // For now, we'll simulate the payment process
        
        $paymentUrl = route('payment.process', ['invoice' => $invoice->id]);
        
        return redirect($paymentUrl);
    }

    /**
     * Process payment callback from gateway.
     */
    public function paymentCallback(Request $request)
    {
        // Verify payment with SSLCOMMERZ
        // This is a simplified version - in production you would verify the signature
        
        $invoice = Invoice::findOrFail($request->invoice_id);
        
        if ($request->status === 'success') {
            $invoice->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_gateway_ref' => $request->transaction_id,
            ]);

            $subscription = $invoice->subscription;
            $subscription->update(['status' => 'active']);

            // Create Google Workspace instance record
            $subscription->company->googleWorkspaceInstance()->create([
                'domain_name' => $subscription->company->name . '.com', // This would be provided by customer
                'status' => 'pending_provisioning',
            ]);

            return redirect()->route('customer.dashboard')
                ->with('success', 'Payment successful! Your Google Workspace account is being provisioned.');
        }

        return redirect()->route('customer.dashboard')
            ->with('error', 'Payment failed. Please try again.');
    }
}
