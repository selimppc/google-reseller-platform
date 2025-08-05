<x-app-layout>
    <x-slot name="title">
        Subscription Management - Google Workspace Reseller
    </x-slot>
    
    <x-slot name="description">
        Manage your Google Workspace subscription and billing details.
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Subscription Management</h1>
                        <p class="text-gray-600">Manage your Google Workspace subscription</p>
                    </div>

                    @if($subscription)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Current Plan -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Current Plan</h3>
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Plan:</span>
                                        <span class="ml-2 text-sm text-gray-900">{{ $subscription->plan->name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Status:</span>
                                        @if($subscription->status === 'active')
                                            <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @elseif($subscription->status === 'trial')
                                            <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Trial
                                            </span>
                                        @elseif($subscription->status === 'pending_payment')
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
                                        <span class="ml-2 text-sm text-gray-900 capitalize">{{ $subscription->billing_cycle }}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Next Payment:</span>
                                        <span class="ml-2 text-sm text-gray-900">{{ $subscription->next_payment_date->format('M d, Y') }}</span>
                                    </div>
                                    @if($subscription->trial_ends_at)
                                        <div>
                                            <span class="text-sm font-medium text-gray-500">Trial Ends:</span>
                                            <span class="ml-2 text-sm text-gray-900">{{ $subscription->trial_ends_at->format('M d, Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Plan Features -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Plan Features</h3>
                                <ul class="space-y-2">
                                    @foreach($subscription->plan->features as $feature)
                                        <li class="flex items-center">
                                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                            <div class="flex space-x-4">
                                @if($subscription->status === 'active')
                                    <form method="POST" action="{{ route('customer.cancel-subscription') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" 
                                                onclick="return confirm('Are you sure you want to cancel your subscription?')">
                                            Cancel Subscription
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('customer.billing') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    View Billing History
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No active subscription</h3>
                            <p class="mt-1 text-sm text-gray-500">You don't have an active subscription yet.</p>
                            <div class="mt-6">
                                <a href="{{ route('pricing') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    View Plans
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 