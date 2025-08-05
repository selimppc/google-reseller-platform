<x-app-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Choose the perfect plan for your business
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Digital Ascent BD provides professional Google Workspace solutions with local support and competitive pricing in BDT
                </p>
            </div>

            <div class="mt-12 space-y-8 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-8 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-3">
                @foreach($plans as $plan)
                <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200 bg-white my-6">
                    <div class="p-8">
                        <h2 class="text-lg leading-6 font-medium text-gray-900">{{ $plan->name }}</h2>
                        <p class="mt-4 text-sm text-gray-500">
                            Perfect for {{ strtolower(str_replace('Business ', '', $plan->name)) }} teams
                        </p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">৳{{ number_format($plan->price_monthly) }}</span>
                            <span class="text-base font-medium text-gray-500">/month</span>
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            ৳{{ number_format($plan->price_annually) }} billed annually
                        </p>
                        <a href="{{ route('checkout.show', $plan->slug) }}" class="mt-8 mb-4 block w-full bg-indigo-600 border border-transparent rounded-md py-3 text-sm font-semibold text-white text-center hover:bg-indigo-700">
                            Choose {{ $plan->name }}
                        </a>
                    </div>
                    <div class="pt-8 pb-10 px-8">
                        <h3 class="text-xs font-semibold text-gray-900 tracking-wide uppercase">What's included</h3>
                        <ul class="mt-6 space-y-4">
                            @foreach($plan->features as $feature)
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-500">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <h3 class="text-lg font-medium text-gray-900">Need a custom plan?</h3>
                <p class="mt-2 text-sm text-gray-500">
                    Contact us for enterprise solutions and custom pricing
                </p>
                <div class="mt-6">
                    <a href="{{ route('support.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 