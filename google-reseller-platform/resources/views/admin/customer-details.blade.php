<x-app-layout>
    <x-slot name="title">
        Customer Details - {{ $company->name }} - Google Workspace Reseller
    </x-slot>
    
    <x-slot name="description">
        View detailed customer information and subscription details.
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ $company->name }}</h1>
                                <p class="text-gray-600">Customer Details</p>
                            </div>
                            <a href="{{ route('admin.customers') }}" class="text-indigo-600 hover:text-indigo-900">
                                ← Back to Customers
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Company Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Company Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Company Name:</span>
                                    <span class="ml-2 text-sm text-gray-900">{{ $company->name }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Contact Email:</span>
                                    <span class="ml-2 text-sm text-gray-900">{{ $company->contact_email }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Contact Phone:</span>
                                    <span class="ml-2 text-sm text-gray-900">{{ $company->contact_phone }}</span>
                                </div>
                                @if($company->billing_address)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Billing Address:</span>
                                        <div class="ml-2 text-sm text-gray-900 mt-1">{{ $company->billing_address }}</div>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Created:</span>
                                    <span class="ml-2 text-sm text-gray-900">{{ $company->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Subscription Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Subscription Information</h3>
                            @if($company->activeSubscription)
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Plan:</span>
                                        <span class="ml-2 text-sm text-gray-900">{{ $company->activeSubscription->plan->name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Status:</span>
                                        @if($company->activeSubscription->status === 'active')
                                            <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @elseif($company->activeSubscription->status === 'trial')
                                            <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Trial
                                            </span>
                                        @elseif($company->activeSubscription->status === 'pending_payment')
                                            <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Payment Pending
                                            </span>
                                        @else
                                            <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Cancelled
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Billing Cycle:</span>
                                        <span class="ml-2 text-sm text-gray-900 capitalize">{{ $company->activeSubscription->billing_cycle }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Next Payment:</span>
                                        <span class="ml-2 text-sm text-gray-900">{{ $company->activeSubscription->next_payment_date->format('M d, Y') }}</span>
                                    </div>
                                    @if($company->activeSubscription->trial_ends_at)
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Trial Ends:</span>
                                            <span class="ml-2 text-sm text-gray-900">{{ $company->activeSubscription->trial_ends_at->format('M d, Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No active subscription</p>
                            @endif
                        </div>
                    </div>

                    <!-- Billing History -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Billing History</h3>
                        @if($company->invoices->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($company->invoices as $invoice)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $invoice->invoice_number }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    ৳{{ number_format($invoice->amount) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($invoice->status === 'paid')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                            Paid
                                                        </span>
                                                    @elseif($invoice->status === 'pending')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                            Failed
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $invoice->due_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $invoice->paid_at ? $invoice->paid_at->format('M d, Y') : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No billing history available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 