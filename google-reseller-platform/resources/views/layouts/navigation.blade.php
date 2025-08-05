<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">
                        Google Workspace Reseller
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.customers') }}" :active="request()->routeIs('admin.customers')">
                                Customers
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.provisioning') }}" :active="request()->routeIs('admin.provisioning')">
                                Provisioning
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.plans') }}" :active="request()->routeIs('admin.plans')">
                                Plans
                            </x-nav-link>
                        @else
                            <x-nav-link href="{{ route('customer.dashboard') }}" :active="request()->routeIs('customer.dashboard')">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link href="{{ route('customer.billing') }}" :active="request()->routeIs('customer.billing')">
                                Billing
                            </x-nav-link>
                            <x-nav-link href="{{ route('customer.subscription') }}" :active="request()->routeIs('customer.subscription')">
                                Subscription
                            </x-nav-link>
                        @endif
                        <x-nav-link href="{{ route('support.index') }}" :active="request()->routeIs('support.*')">
                            Support
                        </x-nav-link>
                    @else
                        <x-nav-link href="{{ route('pricing') }}" :active="request()->routeIs('pricing')">
                            Pricing
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        Log Out
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Register
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        Dashboard
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.customers') }}" :active="request()->routeIs('admin.customers')">
                        Customers
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.provisioning') }}" :active="request()->routeIs('admin.provisioning')">
                        Provisioning
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('admin.plans') }}" :active="request()->routeIs('admin.plans')">
                        Plans
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link href="{{ route('customer.dashboard') }}" :active="request()->routeIs('customer.dashboard')">
                        Dashboard
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('customer.billing') }}" :active="request()->routeIs('customer.billing')">
                        Billing
                    </x-responsive-nav-link>
                    <x-responsive-nav-link href="{{ route('customer.subscription') }}" :active="request()->routeIs('customer.subscription')">
                        Subscription
                    </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link href="{{ route('support.index') }}" :active="request()->routeIs('support.*')">
                    Support
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link href="{{ route('pricing') }}" :active="request()->routeIs('pricing')">
                    Pricing
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav> 