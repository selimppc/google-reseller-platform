<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Processing</h2>

                    <div class="mb-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                            <h3 class="text-lg font-medium text-blue-900 mb-2">Invoice #{{ $invoice->invoice_number }}</h3>
                            <p class="text-blue-700">Amount: ৳{{ number_format($invoice->amount) }}</p>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="mb-4">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Processing Payment</h3>
                        <p class="text-gray-500 mb-6">Please wait while we process your payment...</p>

                        <div class="flex justify-center space-x-4">
                            <form action="{{ route('checkout.callback') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                <input type="hidden" name="status" value="success">
                                <input type="hidden" name="transaction_id" value="TXN{{ time() }}">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                    Simulate Success
                                </button>
                            </form>

                            <form action="{{ route('checkout.callback') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                <input type="hidden" name="status" value="failed">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                    Simulate Failure
                                </button>
                            </form>
                        </div>

                        <p class="text-xs text-gray-400 mt-4">
                            This is a simulation. In production, this would integrate with SSLCOMMERZ or other payment gateways.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 