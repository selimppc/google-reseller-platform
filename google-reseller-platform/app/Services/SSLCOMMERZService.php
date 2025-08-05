<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SSLCOMMERZService
{
    protected $storeId;
    protected $storePassword;
    protected $apiUrl;
    protected $sandbox;

    public function __construct()
    {
        $this->storeId = config('services.sslcommerz.store_id');
        $this->storePassword = config('services.sslcommerz.store_password');
        $this->apiUrl = config('services.sslcommerz.api_url');
        $this->sandbox = config('services.sslcommerz.sandbox');
    }

    /**
     * Create a payment session
     */
    public function createPaymentSession(Invoice $invoice)
    {
        $data = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'total_amount' => $invoice->amount,
            'currency' => 'BDT',
            'tran_id' => $invoice->invoice_number,
            'product_category' => 'Google Workspace',
            'cus_name' => $invoice->company->name,
            'cus_email' => $invoice->company->contact_email,
            'cus_phone' => $invoice->company->contact_phone,
            'cus_add1' => $invoice->company->billing_address,
            'cus_city' => 'Dhaka',
            'cus_country' => 'Bangladesh',
            'shipping_method' => 'NO',
            'num_of_item' => 1,
            'product_name' => $invoice->subscription->plan->name,
            'product_profile' => 'general',
            'success_url' => route('checkout.success'),
            'fail_url' => route('checkout.fail'),
            'cancel_url' => route('checkout.cancel'),
            'ipn_url' => route('webhooks.sslcommerz'),
        ];

        try {
            $response = Http::asForm()->post($this->apiUrl, $data);
            
            if ($response->successful()) {
                $result = $response->json();
                
                if ($result['status'] === 'SUCCESS') {
                    return [
                        'success' => true,
                        'redirect_url' => $result['GatewayPageURL'],
                        'session_id' => $result['sessionkey'],
                    ];
                } else {
                    Log::error('SSLCOMMERZ payment session failed', [
                        'invoice_id' => $invoice->id,
                        'response' => $result,
                    ]);
                    
                    return [
                        'success' => false,
                        'message' => $result['failedreason'] ?? 'Payment session creation failed',
                    ];
                }
            } else {
                Log::error('SSLCOMMERZ API request failed', [
                    'invoice_id' => $invoice->id,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Payment gateway connection failed',
                ];
            }
        } catch (\Exception $e) {
            Log::error('SSLCOMMERZ service error', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
            ]);
            
            return [
                'success' => false,
                'message' => 'Payment service temporarily unavailable',
            ];
        }
    }

    /**
     * Verify payment signature
     */
    public function verifySignature($request)
    {
        $signature = $request->signature;
        $calculatedSignature = md5($this->storePassword . $request->tran_id . $request->amount);
        
        return $signature === $calculatedSignature;
    }

    /**
     * Validate payment response
     */
    public function validatePayment($request)
    {
        // Verify signature
        if (!$this->verifySignature($request)) {
            return [
                'valid' => false,
                'message' => 'Invalid signature',
            ];
        }

        // Check required fields
        $requiredFields = ['tran_id', 'status', 'amount', 'currency'];
        foreach ($requiredFields as $field) {
            if (!$request->has($field)) {
                return [
                    'valid' => false,
                    'message' => "Missing required field: {$field}",
                ];
            }
        }

        // Validate status
        if (!in_array($request->status, ['VALID', 'FAILED', 'CANCELLED'])) {
            return [
                'valid' => false,
                'message' => 'Invalid payment status',
            ];
        }

        return [
            'valid' => true,
            'status' => $request->status,
            'transaction_id' => $request->tran_id,
            'amount' => $request->amount,
        ];
    }
} 