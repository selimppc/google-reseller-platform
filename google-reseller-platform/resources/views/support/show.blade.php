<x-app-layout>
    <x-slot name="title">
        Support Ticket #{{ $ticket->id }} - Google Workspace Reseller
    </x-slot>
    
    <x-slot name="description">
        View support ticket details and conversation.
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Ticket Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Ticket #{{ $ticket->id }}</h1>
                                <p class="text-gray-600">{{ $ticket->subject }}</p>
                            </div>
                            <div class="text-right">
                                @if($ticket->status === 'open')
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Open
                                    </span>
                                @elseif($ticket->status === 'closed')
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Closed
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Awaiting Reply
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-gray-500">
                            Created by {{ $ticket->user->name }} on {{ $ticket->created_at->format('M d, Y \a\t g:i A') }}
                        </div>
                    </div>

                    <!-- Original Message -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Original Message</h3>
                        <div class="text-gray-700 whitespace-pre-wrap">{{ $ticket->message }}</div>
                    </div>

                    <!-- Admin Reply Section (if admin) -->
                    @if(auth()->user()->isAdmin())
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h3 class="text-lg font-medium text-blue-900 mb-2">Admin Reply</h3>
                            <form method="POST" action="{{ route('support.admin.reply', $ticket) }}">
                                @csrf
                                <textarea name="reply" rows="4" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter your reply..."></textarea>
                                <div class="mt-3 flex items-center justify-between">
                                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-md">
                                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="awaiting_reply" {{ $ticket->status === 'awaiting_reply' ? 'selected' : '' }}>Awaiting Reply</option>
                                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Send Reply
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('support.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Support Tickets
                        </a>
                        @if(auth()->user()->isAdmin())
                            <div class="space-x-2">
                                <form method="POST" action="{{ route('support.admin.status', $ticket) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="closed">
                                    <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                        Close Ticket
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 