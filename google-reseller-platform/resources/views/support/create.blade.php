<x-app-layout>
    <x-slot name="title">
        Create Support Ticket - Google Workspace Reseller
    </x-slot>
    
    <x-slot name="description">
        Create a new support ticket for assistance with your Google Workspace services.
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Create Support Ticket</h1>
                        <p class="mt-2 text-gray-600">Submit a new support ticket and we'll get back to you as soon as possible.</p>
                    </div>

                    <form method="POST" action="{{ route('support.store') }}">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea name="message" id="message" rows="6" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Please describe your issue in detail...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('support.index') }}" class="text-indigo-600 hover:text-indigo-900">
                                ← Back to Support Tickets
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Create Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 