<x-app-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Choose the perfect plan for your business
                </h2>
                <p class="mt-6 text-lg text-gray-600">
                    Digital Ascent BD provides professional Google Workspace solutions with local support and competitive pricing in BDT
                </p>
            </div>

            <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-8 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:mx-0 xl:grid-cols-3">
                @foreach($plans as $plan)
                <div class="border border-gray-200 rounded-lg shadow-sm divide-y divide-gray-200 bg-white">
                    <div class="p-6">
                        <h2 class="text-lg leading-6 font-medium text-gray-900">{{ $plan->name }}</h2>
                        <p class="mt-4 text-sm text-gray-500">
                            Perfect for {{ strtolower(str_replace('Business ', '', $plan->name)) }} teams
                        </p>
                        <p class="mt-8">
                            <span class="text-4xl font-extrabold text-gray-900">৳{{ number_format($plan->price_monthly) }}</span>
                            <span class="text-base font-medium text-gray-500">/month</span>
                        </p>
                        <p class="mt-2 text-sm text-gray-500">
                            ৳{{ number_format($plan->price_annually) }} billed annually
                        </p>
                        <a href="{{ route('checkout.show', $plan->slug) }}" class="mt-8 block w-full bg-indigo-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-indigo-700">
                            Choose {{ $plan->name }}
                        </a>
                    </div>
                    <div class="pt-6 pb-8 px-6">
                        <h3 class="text-xs font-semibold text-gray-900 tracking-wide uppercase">What's included</h3>
                        <ul class="mt-6 space-y-4">
                            @foreach($plan->features as $feature)
                            <li class="flex space-x-3">
                                <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <h3 class="text-lg font-medium text-gray-900">Need a custom plan?</h3>
                <p class="mt-4 text-base text-gray-500">
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

    <!-- Footer -->
    <footer class="bg-gray-100 text-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="space-y-8 xl:col-span-1">
                    <span class="text-2xl font-bold text-gray-900">Digital Ascent BD</span>
                    <p class="text-gray-800 text-base">
                        Dhaka-based technology solutions provider helping Bangladeshi SMEs thrive with Google Workspace. Local support, competitive pricing, and enterprise-grade features.
                    </p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-gray-900 transition-colors duration-200">
                            <span class="sr-only">LinkedIn</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">Solutions</h3>
                            <ul class="mt-4 space-y-4">
                                <li><a href="{{ route('pricing') }}" class="text-base text-gray-800 hover:text-gray-900">Pricing</a></li>
                                <li><a href="{{ route('blog.index') }}" class="text-base text-gray-800 hover:text-gray-900">Blog</a></li>
                                <li><a href="{{ route('support.create') }}" class="text-base text-gray-800 hover:text-gray-900">Support</a></li>
                            </ul>
                        </div>
                        <div class="mt-12 md:mt-0">
                            <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase">Company</h3>
                            <ul class="mt-4 space-y-4">
                                <li><a href="#" class="text-base text-gray-800 hover:text-gray-900">About</a></li>
                                <li><a href="#" class="text-base text-gray-800 hover:text-gray-900">Contact</a></li>
                                <li><a href="#" class="text-base text-gray-800 hover:text-gray-900">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-300 pt-8">
                <p class="text-base text-gray-800 xl:text-center">
                    &copy; 2024 Digital Ascent BD. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</x-app-layout> 