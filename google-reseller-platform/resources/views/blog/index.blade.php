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
</x-app-layout> 