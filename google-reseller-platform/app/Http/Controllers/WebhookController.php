<?php

namespace App\Http\Controllers;

use App\Models\GoogleWorkspaceInstance;
use App\Models\Invoice;
use App\Services\SSLCOMMERZService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected $sslcommerzService;

    public function __construct(SSLCOMMERZService $sslcommerzService)
    {
        $this->sslcommerzService = $sslcommerzService;
    }

    /**
     * Handle SSLCOMMERZ payment callback.
     */
    public function sslcommerzCallback(Request $request)
    {
        Log::info('SSLCOMMERZ callback received', $request->all());

        // Validate payment response
        $validation = $this->sslcommerzService->validatePayment($request);
        
        if (!$validation['valid']) {
            Log::error('Invalid SSLCOMMERZ payment', [
                'message' => $validation['message'],
                'data' => $request->all()
            ]);
            return response()->json(['error' => $validation['message']], 400);
        }

        $invoice = Invoice::where('invoice_number', $request->tran_id)->first();

        if (!$invoice) {
            Log::error('Invoice not found for callback', $request->all());
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        // Verify payment status
        if ($request->status === 'VALID' && $request->tran_id) {
            // Payment successful
            $invoice->update([
                'status' => 'paid',
                'paid_at' => now(),
                'payment_gateway_ref' => $request->tran_id,
            ]);

            // Update subscription status
            $subscription = $invoice->subscription;
            if ($subscription) {
                $subscription->update(['status' => 'active']);
            }

            // Create Google Workspace instance if it doesn't exist
            if (!$invoice->company->googleWorkspaceInstance) {
                $invoice->company->googleWorkspaceInstance()->create([
                    'domain_name' => $invoice->company->name . '.com', // This would be provided by customer
                    'status' => 'pending_provisioning',
                ]);
            }

            Log::info('Payment processed successfully', [
                'invoice_id' => $invoice->id,
                'amount' => $invoice->amount,
                'transaction_id' => $request->tran_id,
            ]);

            return response()->json(['status' => 'success']);
        } else {
            // Payment failed
            $invoice->update(['status' => 'failed']);

            Log::error('Payment failed', [
                'invoice_id' => $invoice->id,
                'status' => $request->status,
                'error' => $request->error ?? 'Unknown error',
            ]);

            return response()->json(['status' => 'failed']);
        }
    }

    /**
     * Handle payment gateway IPN (Instant Payment Notification).
     */
    public function paymentIpn(Request $request)
    {
        Log::info('Payment IPN received', $request->all());

        // This method handles IPN from various payment gateways
        // You would implement specific logic for each gateway

        return response()->json(['status' => 'received']);
    }
}
