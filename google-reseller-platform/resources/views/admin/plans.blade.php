<x-app-layout>
    <x-slot name="title">
        Admin - Plans Management - Google Workspace Reseller
    </x-slot>
    
    <x-slot name="description">
        Manage service plans and pricing for Google Workspace.
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Plans Management</h1>
                            <p class="text-gray-600">Manage service plans and pricing</p>
                        </div>
                        <button onclick="openCreateModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Add New Plan
                        </button>
                    </div>

                    @if($plans->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Annual Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($plans as $plan)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $plan->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $plan->slug }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                ৳{{ number_format($plan->price_monthly) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                ৳{{ number_format($plan->price_annually) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($plan->is_active)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="editPlan({{ $plan->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                                <form method="POST" action="{{ route('admin.plans.toggle', $plan) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-{{ $plan->is_active ? 'red' : 'green' }}-600 hover:text-{{ $plan->is_active ? 'red' : 'green' }}-900">
                                                        {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $plans->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No plans</h3>
                            <p class="mt-1 text-sm text-gray-500">No service plans have been created yet.</p>
                            <div class="mt-6">
                                <button onclick="openCreateModal()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Create First Plan
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Plan Modal -->
    <div id="planModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="modalTitle" class="text-lg font-medium text-gray-900 mb-4">Create New Plan</h3>
                <form id="planForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Plan Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                        <input type="text" name="slug" id="slug" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="price_monthly" class="block text-sm font-medium text-gray-700 mb-2">Monthly Price (BDT)</label>
                        <input type="number" name="price_monthly" id="price_monthly" step="0.01" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="price_annually" class="block text-sm font-medium text-gray-700 mb-2">Annual Price (BDT)</label>
                        <input type="number" name="price_annually" id="price_annually" step="0.01" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="google_workspace_sku" class="block text-sm font-medium text-gray-700 mb-2">Google Workspace SKU</label>
                        <input type="text" name="google_workspace_sku" id="google_workspace_sku" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label for="features" class="block text-sm font-medium text-gray-700 mb-2">Features (one per line)</label>
                        <textarea name="features" id="features" rows="4" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="30 GB Storage&#10;Professional Email&#10;Google Drive&#10;Video Meetings"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Save Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Create New Plan';
            document.getElementById('planForm').action = '{{ route("admin.plans.store") }}';
            document.getElementById('planForm').method = 'POST';
            
            // Clear form fields
            document.getElementById('name').value = '';
            document.getElementById('slug').value = '';
            document.getElementById('price_monthly').value = '';
            document.getElementById('price_annually').value = '';
            document.getElementById('google_workspace_sku').value = '';
            document.getElementById('features').value = '';
            
            // Remove PUT method override if it exists
            const methodInput = document.getElementById('_method');
            if (methodInput) {
                methodInput.remove();
            }
            
            document.getElementById('planModal').classList.remove('hidden');
        }

        function editPlan(planId) {
            // Fetch plan data and populate form
            fetch(`/admin/plans/${planId}/edit`)
                .then(response => response.json())
                .then(plan => {
                    document.getElementById('modalTitle').textContent = 'Edit Plan';
                    document.getElementById('planForm').action = `/admin/plans/${planId}`;
                    document.getElementById('planForm').method = 'POST';
                    
                    // Add PUT method override
                    let methodInput = document.getElementById('_method');
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.id = '_method';
                        document.getElementById('planForm').appendChild(methodInput);
                    }
                    methodInput.value = 'PUT';
                    
                    // Populate form fields
                    document.getElementById('name').value = plan.name;
                    document.getElementById('slug').value = plan.slug;
                    document.getElementById('price_monthly').value = plan.price_monthly;
                    document.getElementById('price_annually').value = plan.price_annually;
                    document.getElementById('google_workspace_sku').value = plan.google_workspace_sku;
                    document.getElementById('features').value = plan.features.join('\n');
                    
                    document.getElementById('planModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching plan data:', error);
                    alert('Error loading plan data');
                });
        }

        function closeModal() {
            document.getElementById('planModal').classList.add('hidden');
            
            // Reset form
            document.getElementById('planForm').reset();
            
            // Remove PUT method override if it exists
            const methodInput = document.getElementById('_method');
            if (methodInput) {
                methodInput.remove();
            }
        }
    </script>
</x-app-layout> 