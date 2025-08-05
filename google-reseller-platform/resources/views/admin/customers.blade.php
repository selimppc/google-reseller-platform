<x-app-layout>
    <x-slot name="title">
        Admin - Customers - Google Workspace Reseller
    </x-slot>
    
    <x-slot name="description">
        Manage all customers and their subscriptions.
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Customers</h1>
                        <p class="text-gray-600">Manage all customer accounts and subscriptions</p>
                    </div>

                    @if($customers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscription</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($customers as $company)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $company->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $company->contact_email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $company->contact_phone }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($company->activeSubscription)
                                                    <div class="text-sm font-medium text-gray-900">{{ $company->activeSubscription->plan->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $company->activeSubscription->billing_cycle }}</div>
                                                @else
                                                    <span class="text-sm text-gray-500">No subscription</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($company->activeSubscription)
                                                    @if($company->activeSubscription->status === 'active')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                            Active
                                                        </span>
                                                    @elseif($company->activeSubscription->status === 'trial')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Trial
                                                        </span>
                                                    @elseif($company->activeSubscription->status === 'pending_payment')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Payment Pending
                                                        </span>
                                                    @else
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                            Cancelled
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="text-sm text-gray-500">No subscription</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.customers.details', $company) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $customers->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No customers</h3>
                            <p class="mt-1 text-sm text-gray-500">No customers have registered yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 