<!-- Notification Form Extra Fields -->
<div id="notificationInputs" class="hidden mb-4">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Employee ID</label>
            <input type="number" class="w-full rounded border-gray-300 bg-gray-100" value="{{ $user->employee_id }}" readonly>
        </div>

        <div>
            <label class="block text-sm font-medium">Full Name</label>
            <input type="text" class="w-full rounded border-gray-300 bg-gray-100" value="{{ $user->first_name }} {{ $user->last_name }}" readonly>
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="text" class="w-full rounded border-gray-300 bg-gray-100" value="{{ $user->email }}" readonly>
        </div>

        <div>
            <label class="block text-sm font-medium">Department</label>
            <select class="w-full rounded border-gray-300 px-3 py-2" disabled>
                @foreach (\App\Models\Department::all() as $department)
                    <option value="{{ $department->id }}" {{ $user->department_id == $department->id ? 'selected' : '' }}>
                        {{ $department->department_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Group Assigned</label>
            <select name="group_id" class="w-full rounded border-gray-300 px-3 py-2">
                @foreach (\App\Models\Group::all() as $group)
                    <option value="{{ $group->id }}" {{ $user->group_id == $group->id ? 'selected' : '' }}>
                        Group {{ $group->group_no }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Position</label>
            <select class="w-full rounded border-gray-300 px-3 py-2" disabled>
                @foreach (\App\Models\Position::all() as $position)
                    <option value="{{ $position->id }}" {{ $user->position_id == $position->id ? 'selected' : '' }}>
                        {{ $position->position_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Role</label>
            <select name="role_id" class="w-full rounded border-gray-300 px-3 py-2">
                @foreach (\App\Models\Role::all() as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->role }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Date of <span id="percentLabel">%</span> Worked Hours</label>
            <input type="date" name="percent_date" class="w-full rounded border-gray-300" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Total Worked Hours Completed</label>
            <input type="number" name="total_worked_hours_completed" class="w-full rounded border-gray-300" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Total Worked Hours Required</label>
            <input type="number" name="total_worked_hours_required" class="w-full rounded border-gray-300" required>
        </div>
    </div>

    <!-- Hidden input for percent completed -->
    <input type="hidden" name="percent_completed" id="percent_completed" value="">
</div>
