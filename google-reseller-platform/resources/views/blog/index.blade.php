<x-app-layout>
    <x-slot name="title">
        Blog - Google Workspace Tips and Insights
    </x-slot>
    
    <x-slot name="description">
        Read our latest articles about Google Workspace, business email setup, and productivity tips for businesses in Bangladesh.
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">Blog</h1>
                        <p class="text-gray-600">Latest insights and tips for Google Workspace users</p>
                    </div>

                    @if($posts->count() > 0)
                        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($posts as $post)
                                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                                    @if($post->featured_image)
                                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                                    @endif
                                    <div class="p-6">
                                        @if($post->category)
                                            <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                                                {{ $post->category->name }}
                                            </span>
                                        @endif
                                        <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                            <a href="{{ route('blog.show', $post) }}" class="hover:text-indigo-600">
                                                {{ $post->title }}
                                            </a>
                                        </h2>
                                        <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                                        <div class="flex items-center justify-between text-sm text-gray-500">
                                            <span>By {{ $post->author->name }}</span>
                                            <span>{{ $post->published_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No blog posts available yet.</p>
                        </div>
                    @endif
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