<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process recurring billing for subscriptions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting billing process...');

        // Get all active subscriptions where next_payment_date is today
        $subscriptions = Subscription::where('status', 'active')
            ->where('next_payment_date', today())
            ->with(['company', 'plan'])
            ->get();

        $this->info("Found {$subscriptions->count()} subscriptions due for billing today.");

        foreach ($subscriptions as $subscription) {
            $this->processSubscription($subscription);
        }

        $this->info('Billing process completed.');
    }

    /**
     * Process a single subscription for billing.
     */
    private function processSubscription(Subscription $subscription)
    {
        $this->info("Processing subscription for company: {$subscription->company->name}");

        // Calculate the amount based on billing cycle
        $amount = $subscription->plan->getPrice($subscription->billing_cycle);

        // Create a new invoice
        $invoice = Invoice::create([
            'subscription_id' => $subscription->id,
            'company_id' => $subscription->company_id,
            'amount' => $amount,
            'status' => 'pending',
            'due_date' => today(),
            'invoice_number' => Invoice::generateInvoiceNumber(),
        ]);

        // Calculate next payment date
        $nextPaymentDate = $subscription->billing_cycle === 'monthly' 
            ? today()->addMonth() 
            : today()->addYear();

        // Update subscription
        $subscription->update([
            'status' => 'pending_payment',
            'next_payment_date' => $nextPaymentDate,
        ]);

        // Send email to customer
        $this->sendPaymentReminder($subscription, $invoice);

        $this->info("Invoice created: {$invoice->invoice_number} for amount: {$amount}");
    }

    /**
     * Send payment reminder email to customer.
     */
    private function sendPaymentReminder(Subscription $subscription, Invoice $invoice)
    {
        // Get the primary user for the company
        $user = $subscription->company->users()->first();

        if ($user) {
            // In a real application, you would send an actual email here
            // For now, we'll just log it
            $this->info("Payment reminder sent to: {$user->email}");
            
            // Example email sending (uncomment when mail is configured)
            /*
            Mail::to($user->email)->send(new PaymentReminderMail($invoice));
            */
        }
    }
}
