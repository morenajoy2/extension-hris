<!-- Turnover Inputs -->
<div id="turnoverInputs" class="hidden space-y-3 mb-4">
    <h3 class="font-semibold text-sm">Employee Account Turnover</h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm">Employee ID</label>
            <input type="text" class="w-full rounded border-gray-300" value="{{ $user->employee_id }}" readonly>
        </div>
        <div>
            <label class="block text-sm">Full Name</label>
            <input type="text" class="w-full rounded border-gray-300" value="{{ $user->first_name }} {{ $user->last_name }}" readonly>
        </div>
        <div>
            <label class="block text-sm">Email</label>
            <input type="text" class="w-full rounded border-gray-300" value="{{ $user->email }}" readonly>
        </div>
        <div>
            <label class="block text-sm">Employment Type</label>
            <input type="text" class="w-full rounded border-gray-300" value="{{ $user->employmentType?->type }}" readonly>
        </div>
        <div>
            <label class="block text-sm">Department Team</label>
            <input type="text" class="w-full rounded border-gray-300" value="{{ $user->departmentTeam?->team_name }}" readonly>
        </div>
        <div>
            <label class="block text-sm">Position</label>
            <input type="text" class="w-full rounded border-gray-300" value="{{ $user->position?->position_name }}" readonly>
        </div>
        <div>
            <label class="block text-sm">Orientation Date</label>
            <input type="date" name="orientation_date" class="w-full rounded border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm">First Day</label>
            <input type="date" name="first_day" class="w-full rounded border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm">Last Day</label>
            <input type="date" name="last_day" class="w-full rounded border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm">Exit Day</label>
            <input type="date" name="exit_day" class="w-full rounded border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm">Total Worked Hours Required</label>
            <input type="number" name="worked_hours_required" class="w-full rounded border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm">School Name</label>
            <input type="text" class="w-full rounded border-gray-300" value="{{ $user->school }}" readonly>
        </div>
    </div>

    <br>
    <h3 class="font-semibold text-sm mt-4">Recommended Employee</h3>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm">Recommended Employee ID</label>
            <select name="recommended_employee_id" id="recommended_employee_id" class="w-full rounded border-gray-300 px-3 py-2" onchange="syncRecommendedNameById()" required>
                <option value="">-- Select Employee ID --</option>
                @foreach(\App\Models\User::all() as $u)
                    <option value="{{ $u->id }}" data-name="{{ $u->first_name }} {{ $u->last_name }}">{{ $u->employee_id }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm">Recommended Full Name</label>
            <select id="recommended_employee_name" class="w-full rounded border-gray-300 px-3 py-2" onchange="syncRecommendedIdByName()" required>
                <option value="">-- Select Full Name --</option>
                @foreach(\App\Models\User::all() as $u)
                    <option value="{{ $u->first_name }} {{ $u->last_name }}" data-id="{{ $u->id }}">{{ $u->first_name }} {{ $u->last_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <br>
    <div class="mt-3">
        <label class="block text-sm font-semibold">Do you have tasks to turn over? <span class="text-red-500">*</span></label>
        <div class="flex gap-4 mt-1">
            <label class="inline-flex items-center">
                <input type="radio" name="has_tasks" value="yes" class="has-tasks-toggle" required>
                <span class="ml-2">Yes</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="has_tasks" value="no" class="has-tasks-toggle">
                <span class="ml-2">No</span>
            </label>
        </div>
    </div>

    <div id="turnedOverTasksWrapper" class="mt-2 hidden">
        <label class="block text-sm">List All Tasks</label>
        <textarea name="turned_over_tasks" rows="2" class="w-full rounded border-gray-300 px-3 py-2" placeholder="List all tasks or write N/A"></textarea>
    </div>

    <br>
    <h3 class="font-semibold text-sm mt-4">Account Turnover</h3>
    <div>
        <label class="block text-sm">Your company account transferred to the new owner</label>
        <input type="text" name="company_accounts_transferred" class="w-full rounded border-gray-300" required>
    </div>
    <div>
        <label class="block text-sm">Access Credentials Handed Over</label>
        <input type="text" name="credentials_handed_over" class="w-full rounded border-gray-300" required>
    </div>

    <br>
    <h3 class="font-semibold text-sm mt-4">Data Removal from Personal Devices</h3>
    <div class="mt-4">
        <label class="inline-flex items-start gap-2">
            <input type="checkbox" name="acknowledge_files" value="yes" required >
            <span class="text-sm leading-tight">
                <strong>Task & File Turnover:</strong> Ensure all work files are transferred and deleted.
            </span>
        </label>
    </div>

    <div class="mt-4">
        <label class="inline-flex items-start gap-2">
            <input type="checkbox" name="acknowledge_device" value="yes" required >
            <span class="text-sm leading-tight">
                <strong>Device & Security Compliance:</strong> Confirm company data has been removed from personal devices.
            </span>
        </label>
    </div>

    <div class="mt-4">
        <label class="inline-flex items-start gap-2">
            <input type="checkbox" name="acknowledge_deletion" value="yes" required >
            <span class="text-sm leading-tight">
                <strong>Device & Security Compliance:</strong> Confirmation of secure file deletion.
            </span>
        </label>
    </div>

    <br>
    <h3 class="font-semibold text-sm mt-4">Verification</h3>
    <div class="grid grid-cols-2 gap-4">
        <!-- Team Leader -->
        <div>
            <label class="block text-sm">Department Team Leader ID</label>
            <select name="team_leader_id" id="team_leader_id" class="w-full rounded border-gray-300 px-3 py-2" onchange="syncTeamLeaderNameById()" required>
                <option value="">-- Select Leader ID --</option>
                @foreach(\App\Models\User::whereHas('role', fn($q) => $q->where('role', 'Team Leader'))->get() as $leader)
                    <option value="{{ $leader->id }}" data-name="{{ $leader->first_name }} {{ $leader->last_name }}">{{ $leader->employee_id }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm">Department Team Leader Name</label>
            <select id="team_leader_name" class="w-full rounded border-gray-300 px-3 py-2" onchange="syncTeamLeaderIdByName()" required>
                <option value="">-- Select Leader Name --</option>
                @foreach(\App\Models\User::whereHas('role', fn($q) => $q->where('role', 'Team Leader'))->get() as $leader)
                    <option value="{{ $leader->first_name }} {{ $leader->last_name }}" data-id="{{ $leader->id }}">{{ $leader->first_name }} {{ $leader->last_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Corporate Leader -->
        <div>
            <label class="block text-sm">Corporate Services Leader ID</label>
            <select name="corporate_leader_id" id="corporate_leader_id" class="w-full rounded border-gray-300 px-3 py-2" onchange="syncCorporateLeaderNameById()" required>
                <option value="">-- Select Leader ID --</option>
                @foreach(\App\Models\User::whereHas('role', fn($q) => $q->where('role', 'Team Leader'))->get() as $leader)
                    <option value="{{ $leader->id }}" data-name="{{ $leader->first_name }} {{ $leader->last_name }}">{{ $leader->employee_id }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm">Corporate Services Leader Name</label>
            <select id="corporate_leader_name" class="w-full rounded border-gray-300 px-3 py-2" onchange="syncCorporateLeaderIdByName()" required>
                <option value="">-- Select Leader Name --</option>
                @foreach(\App\Models\User::whereHas('role', fn($q) => $q->where('role', 'Team Leader'))->get() as $leader)
                    <option value="{{ $leader->first_name }} {{ $leader->last_name }}" data-id="{{ $leader->id }}">{{ $leader->first_name }} {{ $leader->last_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-4">
        <label class="inline-flex items-start gap-2">
            <input type="checkbox" name="final_acknowledge" value="yes" required>
            <span class="block text-sm font-medium">I have read and agree to the Terms and Conditions and Privacy Policy.</span>
        </label>
    </div>

    <div>
        <label class="block text-sm font-medium">E-signature File</label>
        <input type="file" name="esignature_turnover_file" class="w-full rounded border-gray-300">
    </div>
</div>
