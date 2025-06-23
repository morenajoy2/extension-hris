@php
    $role = Auth::user()->role;
@endphp

<div class="mt-6 bg-white ">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">📄 Latest Requirements</h2>

    <div class="overflow-x-auto">
        <div class="max-h-96 overflow-y-auto border rounded">
            <table class="min-w-full table-auto border text-sm">
                <thead class="bg-gray-100 text-left sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Employee</th>
                        <th class="px-4 py-2 border">Type</th>
                        <th class="px-4 py-2 border">Upload Date</th>
                        <th class="px-4 py-2 border">File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requirements as $req)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $req->id }}</td>
                            <td class="border px-4 py-2">{{ $req->user->first_name }} {{ $req->user->last_name }}</td>
                            <td class="border px-4 py-2">{{ $req->type }}</td>
                            <td class="border px-4 py-2">
                                {{ $req->upload_date ? $req->upload_date->format('Y-m-d') : '-' }}
                            </td>
                            <td class="border px-4 py-2">
                                @if ($req->file)
                                    <a href="{{ asset('storage/' . $req->file) }}" target="_blank" class="text-indigo-600 underline">View</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No recent requirements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
