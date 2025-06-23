<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center pb-4">
            <div>
                📁 201 Tracker: {{ $user->first_name . ' ' . $user->last_name }}
            </div>
                <button onclick="openModal('addRequirementModal')" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-400 text-sm">
                    ➕ Add Requirement
                </button>
        </div>
    </x-slot>

    <!-- Flash Messages -->
    @if(session('success'))
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        </script>
    @endif

    @if($errors->any())
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: '{!! implode("<br>", $errors->all()) !!}',
                    showConfirmButton: true
                });
            }
        </script>
    @endif

   @if($errors->has('duplicate'))
        <script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate Upload',
                    html: {!! json_encode(
                        preg_replace(
                            '/"(.+?)"/', 
                            '<strong>$1</strong>', 
                            $errors->first('duplicate')
                        )
                    ) !!},
                    showConfirmButton: true
                });
            }
        </script>
    @endif

    <!-- Add Requirement Modal -->
    <div id="addRequirementModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-semibold mb-4">Add Requirement</h2>

            <form action="{{ route('requirements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="max-h-[80vh] overflow-y-auto pr-2">
                    <!-- Requirement Type -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium">Requirement Type</label>
                        <select name="type" id="type" required onchange="toggleOtherTypeInput()" class="w-full border-gray-300 rounded mt-1 px-3 py-2">
                            <option value="">-- Select Type --</option>
                            @foreach ($allTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <!-- Other Type Input -->
                    <div class="mb-4 hidden" id="otherTypeDiv">
                        <label for="other_type" class="block text-sm font-medium">Specify Other Requirement</label>
                        <input type="text" name="other_type" id="other_type" class="w-full border-gray-300 rounded mt-1">
                    </div>

                    <!-- Dynamic Requirement Fields -->
                    @include('employees.partials.application-fields')
                    @include('employees.partials.notification-fields')
                    @include('employees.partials.turnover-fields')
                    @include('employees.partials.exit-fields')

                    <!-- Requires Signature -->
                    <div class="mb-4">
                        <label for="requires_signature" class="block text-sm font-medium">Requires Signature?</label>
                        <select name="requires_signature" id="requires_signature" required class="w-full border-gray-300 rounded mt-1 px-3 py-2">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-4" id="fileUploadDiv">
                        <label for="file" class="block text-sm font-medium">File</label>
                        <input type="file" name="file" id="file" required class="w-full border-gray-300 rounded mt-1 py-2">
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal('addRequirementModal')" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Requirements Table -->
    <div class="overflow-x-auto">
        <table class="min-w-max text-xs sm:text-sm border border-gray-200 mt-4 w-full">
            <thead class="bg-gray-100 text-left text-xs sm:text-sm">
                <tr>
                    <th class="px-4 py-2 border ">Requirement Types</th>
                    <th class="px-4 py-2 border">File Status</th>
                    <th class="px-4 py-2 border">Uploaded File</th>
                    <th class="px-4 py-2 border">Upload Date</th>
                    <th class="px-4 py-2 border">Requires Signature</th>
                    <th class="px-4 py-2 border">Signature Status</th>
                    <th class="px-4 py-2 border">Signed Date</th>
                    <th class="px-4 py-2 border">Signed File</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allTypes as $type)
                    @php
                        $req = $requirements->firstWhere('type', $type);
                    @endphp
                    <tr>
                        <td class="border px-4 py-2 text-xs sm:text-sm">{{ $type }}</td>
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            @if ($req && $req->status === 'Completed')
                                ✅ Uploaded
                            @else
                                ❌ Not Uploaded
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            @if ($req && $req->file)
                                <a href="{{ asset('storage/' . $req->file) }}"
                                target="_blank"
                                class="block max-w-[200px] truncate text-blue-600 hover:underline"
                                title="{{ basename($req->file) }}">
                                    {{ basename($req->file) }}
                                </a>
                            @else
                                {{-- blank --}}
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-xs sm:text-sm">{{ $req && $req->upload_date ? $req->upload_date->format('Y-m-d') : '' }}</td>
                        
                        <!-- Requires Signature -->
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            {{ $req && $req->file ? ($req->requires_signature === 'Yes' ? 'Yes' : 'No') : '' }}
                        </td>

                        <!-- Signature Status (Always visible) -->
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            @if ($req && $req->file)
                                @if ($req->requires_signature === 'No')
                                    {{-- blank --}}
                                @else
                                    {{ $req->signature_status ?? 'Unsigned' }}
                                @endif
                            @endif
                        </td>

                        <!-- Signed Date (visible only if signed file exists or user is HR/Admin) -->
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            @if ($req && $req->signed_file || Auth::user()->role === 'Admin' || Auth::user()->position === 'HR')
                                {{ $req && $req->signed_date ? $req->signed_date->format('Y-m-d') : '' }}
                            @else
                                {{-- blank --}}
                            @endif
                        </td>

                        <!-- Signed File Link (same logic) -->
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            @if ($req && $req->signed_file || Auth::user()->role === 'Admin' || Auth::user()->position === 'HR')
                                @if ($req && $req->signed_file)
                                    <a href="{{ asset('storage/' . $req->signed_file) }}"
                                    target="_blank"
                                    class="block max-w-[200px] truncate text-blue-600 hover:underline"
                                    title="{{ basename($req->signed_file) }}">
                                        {{ basename($req->signed_file) }}
                                    </a>
                                @else
                                    {{-- blank --}}
                                @endif
                            @else
                                {{-- blank --}}
                            @endif
                        </td>
                        <!-- Actions -->
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            <div class="flex items-center gap-2">
                                @if ($req && $req->file)
                                    @if (($req->requires_signature === 'Yes') && (Auth::user()->role === 'Admin' || Auth::user()->position === 'HR'))
                                        <button onclick="openSignedModal({{ $req->id }})" class="text-blue-600 hover:underline whitespace-nowrap">
                                            {{ $req->signed_file ? 'Replace Signed File' : 'Add Signed File' }}
                                        </button>
                                    @endif
                                    <button onclick="openDeleteModal({{ $req->id }})" class="text-red-600 hover:underline whitespace-nowrap">Delete</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach

                <!-- Optional/Others -->
                @php
                    $otherRequirements = $requirements->filter(function($req) use ($allTypes) {
                        return !in_array($req->type, $allTypes);
                    });
                @endphp

                @foreach ($otherRequirements as $req)
                    <tr>
                        <td class="border px-4 py-2 text-xs sm:text-sm">{{ $req->type }}</td>
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            @if ($req->status === 'Completed')
                                ✅ Uploaded
                            @else
                                ❌ Not Uploaded
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            @if ($req->file)
                                <a href="{{ asset('storage/' . $req->file) }}"
                            target="_blank"
                            class="block max-w-[200px] truncate text-blue-600 hover:underline"
                            title="{{ basename($req->file) }}">
                                {{ basename($req->file) }}
                            </a>
                            @else
                                {{-- blank --}}
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-xs sm:text-sm">{{ $req->upload_date ? $req->upload_date->format('Y-m-d') : '' }}</td>
                        
                        <!-- Requires Signature -->
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            {{ $req && $req->file ? ($req->requires_signature) : '' }}
                        </td>

                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            {{ $req && $req->file ? ($req->signature_status ?? '') : '' }}
                        </td>

                        <!-- Signed Date (visible only if signed file exists or user is HR/Admin) -->
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            @if ($req && $req->signed_file || Auth::user()->role === 'Admin' || Auth::user()->position === 'HR')
                                {{ $req && $req->signed_date ? $req->signed_date->format('Y-m-d') : '-' }}
                            @else
                                {{-- blank --}}
                            @endif
                        </td>

                        <!-- Signed File Link (visible only if signed file exists or user is HR/Admin) -->
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            @if ($req && $req->signed_file || Auth::user()->role === 'Admin' || Auth::user()->position === 'HR')
                                @if ($req && $req->signed_file)
                                    <a href="{{ asset('storage/' . $req->signed_file) }}"
                                    target="_blank"
                                    class="block max-w-[200px] truncate text-blue-600 hover:underline"
                                    title="{{ basename($req->signed_file) }}">
                                        {{ basename($req->signed_file) }}
                                    </a>
                                @else
                                    {{-- blank --}}
                                @endif
                            @else
                                    {{-- blank --}}
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="border px-4 py-2 text-xs sm:text-sm">
                            <div class="flex items-center gap-2">
                                @if ($req && $req->file)
                                    @if (($req->requires_signature === 'Yes') && (Auth::user()->role === 'Admin' || Auth::user()->position === 'HR'))
                                        <button onclick="openSignedModal({{ $req->id }})" class="text-blue-600 hover:underline whitespace-nowrap">
                                            {{ $req->signed_file ? 'Replace Signed File' : 'Add Signed File' }}
                                        </button>
                                    @endif
                                    <button onclick="openDeleteModal({{ $req->id }})" class="text-red-600 hover:underline whitespace-nowrap">Delete</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 hidden bg-black bg-opacity-50 justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-md text-center">
            <h2 class="text-lg font-semibold mb-4">Confirm Delete?</h2>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center space-x-2">
                    <button type="button" onclick="closeModal('deleteModal')" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Signed File Upload Modal -->
    <div id="signedModal" class="fixed inset-0 hidden bg-black bg-opacity-50 justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-full max-w-4xl">
            <h2 class="text-lg font-semibold mb-4">Upload Signed File</h2>
            <form id="signedForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-4">
                    <label for="signed_file" class="block text-sm font-medium">Signed File</label>
                    <input type="file" name="signed_file" required class="w-full border-gray-300 rounded mt-1 py-2">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('signedModal')" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('flex');
            document.getElementById(id).classList.add('hidden');
        }

        function openDeleteModal(id) {
            const form = document.getElementById('deleteForm');
            form.action = `/201/${id}/delete`;
            openModal('deleteModal');
        }

        function openSignedModal(id) {
            const form = document.getElementById('signedForm');
            form.action = `/201/${id}/signed`; // Route to handle signed file
            openModal('signedModal');
        }

        const applicationTypes = [
            'Resume', 'Photo ID', 'Workstation Photo', 'Internet Speed Photo',
            'PC Specification Photo', 'School ID', 'Signed Consent', 'Valid ID Signed Consent',
            'Endorsement Letter', 'MOA'
        ];

        function toggleApplicationInputs() {
            const selected = document.getElementById('type').value;
            const appFields = document.getElementById('applicationInputs');
            appFields.classList.toggle('hidden', !applicationTypes.includes(selected));
        }

        const notificationTypes = [
            '25% Notification', '50% Notification', '75% Notification', '100% Notification'
        ];

        function toggleNotificationInputs() {
            const selected = document.getElementById('type').value;
            const notifDiv = document.getElementById('notificationInputs');
            const percentInput = document.getElementById('percent_completed');
            const percentLabel = document.getElementById('percentLabel');

            const shouldShow = notificationTypes.includes(selected);
            notifDiv.classList.toggle('hidden', !shouldShow);

            // Enable or disable all input/selects inside notification section
            const fields = notifDiv.querySelectorAll('input, select, textarea');

            fields.forEach(field => {
                if (shouldShow) {
                    field.removeAttribute('disabled');
                    if (field.dataset.required === "true") {
                        field.setAttribute('required', 'required');
                    }
                } else {
                    field.setAttribute('disabled', 'disabled');
                    if (field.hasAttribute('required')) {
                        field.dataset.required = "true";
                        field.removeAttribute('required');
                    }
                }
            });

            if (shouldShow) {
                const percent = selected.split('%')[0]; // Get '25' from '25% Notification'
                percentInput.value = percent;
                percentLabel.textContent = percent + '%';
            } else {
                percentInput.value = '';
                percentLabel.textContent = '';
            }
        }


        const turnoverTypes = ['Turnover'];

        function setupTurnedOverTasksToggle() {
            const radios = document.querySelectorAll('input.has-tasks-toggle');
            const tasksWrapper = document.getElementById('turnedOverTasksWrapper');

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'yes') {
                        tasksWrapper.classList.remove('hidden');
                    } else {
                        tasksWrapper.classList.add('hidden');
                    }
                });

                // Initial check (in case user revisits the modal or switches types)
                if (radio.checked && radio.value === 'yes') {
                    tasksWrapper.classList.remove('hidden');
                }
            });
        }

        function toggleTurnoverInputs() {
            const selected = document.getElementById('type').value;
            const turnoverSection = document.getElementById('turnoverInputs');
            const shouldShow = selected === 'Turnover';

            turnoverSection.classList.toggle('hidden', !shouldShow);

            const fields = turnoverSection.querySelectorAll('input, select, textarea');

            fields.forEach(field => {
                if (shouldShow) {
                    field.removeAttribute('disabled');
                    // Restore `required` if it was originally required
                    if (field.dataset.required === "true") {
                        field.setAttribute('required', 'required');
                    }
                } else {
                    field.setAttribute('disabled', 'disabled');
                    // Save the `required` state before removing it
                    if (field.hasAttribute('required')) {
                        field.dataset.required = "true";
                        field.removeAttribute('required');
                    }
                }
            });
        }


        document.addEventListener('DOMContentLoaded', () => {
            setupExitTasksToggle();
        });

        const exitClearanceTypes = ['Exit Clearance'];

        function toggleExitClearanceInputs() {
            const selected = document.getElementById('type').value;
            const exitDiv = document.getElementById('exitClearanceInputs');
            const shouldShow = selected === 'Exit Clearance';

            exitDiv.classList.toggle('hidden', !shouldShow);

            const fields = exitDiv.querySelectorAll('input, select, textarea');

            fields.forEach(field => {
                if (shouldShow) {
                    field.removeAttribute('disabled');
                    if (field.dataset.required === "true") {
                        field.setAttribute('required', 'required');
                    }
                } else {
                    field.setAttribute('disabled', 'disabled');
                    if (field.hasAttribute('required')) {
                        field.dataset.required = "true";
                        field.removeAttribute('required');
                    }
                }
            });
        }


        function setupExitTasksToggle() {
            const radios = document.querySelectorAll('input.has-exit-tasks-toggle');
            const exitTasksWrapper = document.getElementById('exitTasksWrapper');

            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === 'yes') {
                        exitTasksWrapper.classList.remove('hidden');
                    } else {
                        exitTasksWrapper.classList.add('hidden');
                    }
                });

                // Initial check if "yes" was pre-selected
                if (radio.checked && radio.value === 'yes') {
                    exitTasksWrapper.classList.remove('hidden');
                }
            });
        }

        function toggleOtherTypeInput() {
            const type = document.getElementById('type').value;
            const otherDiv = document.getElementById('otherTypeDiv');
            const fileUploadDiv = document.getElementById('fileUploadDiv');
            const fileInput = document.getElementById('file');

            otherDiv.classList.toggle('hidden', type !== 'Others');

            // Determine if file upload should be shown or hidden
            const showFileUpload = (
                applicationTypes.includes(type) ||
                notificationTypes.includes(type) ||
                type === 'Others'
            );

            fileUploadDiv.classList.toggle('hidden', !showFileUpload);

            if (showFileUpload) {
                fileInput.removeAttribute('disabled');
                fileInput.setAttribute('required', 'required');
            } else {
                fileInput.setAttribute('disabled', 'disabled');
                fileInput.removeAttribute('required');
            }

            toggleApplicationInputs();
            toggleNotificationInputs();
            toggleTurnoverInputs();
            toggleExitClearanceInputs();
        }


         function syncRecommendedNameById() {
            const idSelect = document.getElementById('recommended_employee_id');
            const nameSelect = document.getElementById('recommended_employee_name');
            const selectedIdOption = idSelect.options[idSelect.selectedIndex];
            const targetName = selectedIdOption.getAttribute('data-name');

            for (let i = 0; i < nameSelect.options.length; i++) {
                if (nameSelect.options[i].value === targetName) {
                    nameSelect.selectedIndex = i;
                    break;
                }
            }
        }

        function syncRecommendedIdByName() {
            const nameSelect = document.getElementById('recommended_employee_name');
            const idSelect = document.getElementById('recommended_employee_id');
            const selectedNameOption = nameSelect.options[nameSelect.selectedIndex];
            const targetId = selectedNameOption.getAttribute('data-id');

            for (let i = 0; i < idSelect.options.length; i++) {
                if (idSelect.options[i].value === targetId) {
                    idSelect.selectedIndex = i;
                    break;
                }
            }
        }

        function syncTeamLeaderIdByName() {
            const select = document.getElementById('team_leader_name');
            const selected = select.options[select.selectedIndex];
            const id = selected.getAttribute('data-id');
            document.getElementById('team_leader_id').value = id || '';
        }

        function syncTeamLeaderNameById() {
            const select = document.getElementById('team_leader_id');
            const selected = select.options[select.selectedIndex];
            const name = selected.getAttribute('data-name');
            document.getElementById('team_leader_name').value = name || '';
        }

        function syncCorporateLeaderIdByName() {
            const select = document.getElementById('corporate_leader_name');
            const selected = select.options[select.selectedIndex];
            const id = selected.getAttribute('data-id');
            document.getElementById('corporate_leader_id').value = id || '';
        }

        function syncCorporateLeaderNameById() {
            const select = document.getElementById('corporate_leader_id');
            const selected = select.options[select.selectedIndex];
            const name = selected.getAttribute('data-name');
            document.getElementById('corporate_leader_name').value = name || '';
        }

        window.onload = function () {
            toggleOtherTypeInput();
            setupTurnedOverTasksToggle();
            setupExitTasksToggle();
            toggleTurnoverInputs();
            toggleNotificationInputs();
            toggleExitClearanceInputs(); 
        };
    </script>
</x-app-layout>