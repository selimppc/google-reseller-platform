<x-app-layout>
    <x-slot name="title">
        Admin - Provisioning Queue - Google Workspace Reseller
    </x-slot>
    
    <x-slot name="description">
        Manage Google Workspace instance provisioning for customers.
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Provisioning Queue</h1>
                        <p class="text-gray-600">Manage Google Workspace instance provisioning for customers</p>
                    </div>

                    @if($instances->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Google Customer ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($instances as $instance)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $instance->company->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $instance->company->contact_email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $instance->domain_name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($instance->status === 'active')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                @elseif($instance->status === 'pending_provisioning')
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending Provisioning
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Suspended
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $instance->google_customer_id ?: 'Not assigned' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($instance->status === 'pending_provisioning')
                                                    <button onclick="updateInstance({{ $instance->id }})" class="text-indigo-600 hover:text-indigo-900">
                                                        Update Status
                                                    </button>
                                                @else
                                                    <span class="text-gray-400">No action needed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $instances->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No instances to provision</h3>
                            <p class="mt-1 text-sm text-gray-500">All Google Workspace instances have been provisioned.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Update Instance Modal -->
    <div id="updateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Instance Status</h3>
                <form id="updateForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="google_customer_id" class="block text-sm font-medium text-gray-700 mb-2">Google Customer ID</label>
                        <input type="text" name="google_customer_id" id="google_customer_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter Google Customer ID">
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="active">Active</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateInstance(instanceId) {
            document.getElementById('updateForm').action = `/admin/provisioning/${instanceId}`;
            document.getElementById('updateModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }
    </script>
</x-app-layout> 