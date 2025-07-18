<x-app-layout>
    <x-slot name="header">
        <div class="pb-4">
            👤 Employee Tracker
        </div>
    </x-slot>

    <div class="mb-4">
        <form method="GET" action="{{ route('employees.index') }}" class="flex flex-col md:flex-row gap-2 md:gap-4 items-stretch md:items-center relative">
            <div class="relative w-full">
                <input type="text" id="search-input" name="search" placeholder="Search by name, ID, or school"
                    value="{{ request('search') }}"
                    class="rounded border-gray-300 w-full relative z-10 px-4 py-2" autocomplete="off" />
                <ul id="search-results" class="absolute z-20 bg-white border border-gray-300 rounded w-full hidden"></ul>
            </div>

            <div class="w-full md:w-auto">
                <select name="filter" class="border-gray-300 rounded px-4 py-2 w-full md:w-auto" onchange="this.form.submit()">
                    <option value="">Filter</option>
                    <option value="latest" {{ request('filter') === 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="oldest" {{ request('filter') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="active" {{ request('filter') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="exited" {{ request('filter') === 'exited' ? 'selected' : '' }}>Exited</option>
                </select>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-gray-200 text-sm md:text-base">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border whitespace-nowrap">ID</th>
                    <th class="px-4 py-2 border whitespace-nowrap">Employee ID</th>
                    <th class="px-4 py-2 border whitespace-nowrap">Name</th>
                    <th class="px-4 py-2 border whitespace-nowrap">Employment Type</th>
                    <th class="px-4 py-2 border whitespace-nowrap">School</th>
                    <th class="px-4 py-2 border whitespace-nowrap">Status</th>
                    <th class="px-4 py-2 border whitespace-nowrap">% Completion</th>
                    <th class="px-4 py-2 border whitespace-nowrap">Last Updated</th>
                    <th class="px-4 py-2 border whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $user->id }}</td>
                        <td class="border px-4 py-2">{{ $user->employee_id }}</td>
                        <td class="border px-4 py-2">{{ $user->first_name . ' ' . $user->last_name }}</td>
                        <td class="border px-4 py-2">{{ $user->employment_type }}</td>
                        <td class="border px-4 py-2">{{ $user->school ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">
                            <form method="POST" action="{{ route('employees.updateStatus', $user->id) }}">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 bg-white w-full">
                                    <option value="active" {{ $user->status === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="exited" {{ $user->status === 'Exited' ? 'selected' : '' }}>Exited</option>
                                </select>
                            </form>
                        </td>
                        <td class="border px-4 py-2 text-center align-middle">
                            <div class="relative h-6 rounded-full bg-gray-200 w-full">
                                <div class="absolute left-0 top-0 h-6 bg-green-500 rounded-full" style="width: {{ $user->completion_rate }}%"></div>
                                <div class="absolute inset-0 flex items-center justify-center text-sm font-semibold text-black">
                                    {{ $user->completion_rate }}%
                                </div>
                            </div>
                        </td>

                        <td class="border px-4 py-2">
                            {{ $user->updated_at ? $user->updated_at->format('Y-m-d') : '-' }}
                        </td>
                        <td class="border px-4 py-2 space-y-1 md:space-x-2 md:space-y-0 flex-col md:flex-row text-center">
                            <a href="{{ route('employees.show', $user->id) }}" class="text-blue-600 hover:underline">View</a>

                            <!-- Delete Button trigger modal -->
                            <button type="button" onclick="openModal({{ $user->id }})" class="text-red-600 hover:underline">Delete</button>

                            <!-- Modal -->
                            <div id="deleteModal-{{ $user->id }}" class="hidden inset-0 bg-gray-800 bg-opacity-50 fixed z-50 items-center justify-center">
                                <div class="bg-white p-6 rounded shadow-md w-80 mx-auto">
                                    <h2 class="text-lg font-semibold mb-4">Confirm Delete</h2>
                                    <p class="mb-4">Are you sure you want to delete <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>?</p>
                                    <div class="flex justify-end space-x-2">
                                        <button onclick="closeModal({{ $user->id }})" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                                        <form method="POST" action="{{ route('employees.destroy', $user->id) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>

    <script>
        function openModal(userId) {
            const modal = document.getElementById('deleteModal-' + userId);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(userId) {
            const modal = document.getElementById('deleteModal-' + userId);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
