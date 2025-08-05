<x-app-layout>
    @section('title', 'Payment Successful - Google Workspace Reseller')
    @section('description', 'Your Google Workspace subscription has been activated successfully.')
    
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="text-center">
                        <div class="mb-4">
                            <svg class="mx-auto h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Payment Successful!</h2>
                        <p class="text-gray-600 mb-6">Your Google Workspace subscription has been activated successfully.</p>

                        <div class="bg-green-50 border border-green-200 rounded-md p-4 mb-6">
                            <h3 class="text-lg font-medium text-green-900 mb-2">Invoice #{{ $invoice->invoice_number }}</h3>
                            <p class="text-green-700">Amount: ৳{{ number_format($invoice->amount) }}</p>
                            <p class="text-green-700">Plan: {{ $invoice->subscription->plan->name }}</p>
                        </div>

                        <div class="space-y-4">
                            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Go to Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Tag Manager Conversion Tracking -->
    <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            'event': 'purchase',
            'ecommerce': {
                'transaction_id': '{{ $invoice->id }}',
                'value': '{{ $invoice->amount }}',
                'currency': 'BDT',
                'items': [{
                    'item_id': '{{ $invoice->subscription->plan->google_workspace_sku }}',
                    'item_name': '{{ $invoice->subscription->plan->name }}',
                    'price': '{{ $invoice->amount }}',
                    'quantity': 1
                }]
            }
        });
    </script>
</x-app-layout> 