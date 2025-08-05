<x-app-layout>
    <x-slot name="title">
        {{ $post->title }} - Google Workspace Blog
    </x-slot>
    
    <x-slot name="description">
        {{ $post->excerpt }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <article class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Breadcrumb -->
                    <nav class="mb-6">
                        <ol class="flex items-center space-x-2 text-sm text-gray-500">
                            <li><a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li><a href="{{ route('blog.index') }}" class="hover:text-indigo-600">Blog</a></li>
                            <li><span class="mx-2">/</span></li>
                            <li class="text-gray-900">{{ $post->title }}</li>
                        </ol>
                    </nav>

                    <!-- Article Header -->
                    <header class="mb-8">
                        @if($post->category)
                            <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-full mb-4">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-6">
                            <span>By {{ $post->author->name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $post->published_at->format('F d, Y') }}</span>
                        </div>

                        @if($post->featured_image)
                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg mb-6">
                        @endif
                    </header>

                    <!-- Article Content -->
                    <div class="prose max-w-none">
                        {!! $post->body !!}
                    </div>

                    <!-- Call to Action -->
                    <div class="mt-8 p-6 bg-indigo-50 rounded-lg">
                        <h3 class="text-lg font-semibold text-indigo-900 mb-2">Ready to get started?</h3>
                        <p class="text-indigo-700 mb-4">Get professional Google Workspace for your business with local support and competitive pricing.</p>
                        <a href="{{ route('pricing') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            View Plans
                        </a>
                    </div>
                </div>
            </article>

            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Posts</h2>
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($relatedPosts as $relatedPost)
                            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                                <div class="p-6">
                                    @if($relatedPost->category)
                                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                                            {{ $relatedPost->category->name }}
                                        </span>
                                    @endif
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <a href="{{ route('blog.show', $relatedPost) }}" class="hover:text-indigo-600">
                                            {{ $relatedPost->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 text-sm">{{ Str::limit($relatedPost->excerpt, 100) }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 