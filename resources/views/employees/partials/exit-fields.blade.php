<!-- Exit Clearance Inputs -->
<div id="exitClearanceInputs" class="hidden space-y-3 mb-4">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm">Exit Type</label>
            <select name="exit_type" class="w-full rounded border-gray-300 px-3 py-2" required>
                <option value="">-- Select Exit Type --</option>
                @foreach (\App\Models\User::exitTypes() as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm">Turned Over To</label>
            <select name="turnover_by" id="turnover_by" class="w-full rounded border-gray-300 px-3 py-2" required>
                <option value="">-- Select Leader --</option>
                @foreach(\App\Models\Role::whereIn('role', ['Team Leader', 'Group Leader'])->get() as $role)
                    <option value="{{ $role->role }}">{{ $role->role }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-3">
        <label class="block text-sm font-semibold">Do you have tasks to turn over for exit clearance? <span class="text-red-500">*</span></label>
        <div class="flex gap-4 mt-1">
            <label class="inline-flex items-center">
                <input type="radio" name="has_exit_tasks" value="yes" class="has-exit-tasks-toggle" required>
                <span class="ml-2">Yes</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="has_exit_tasks" value="no" class="has-exit-tasks-toggle">
                <span class="ml-2">No</span>
            </label>
        </div>
    </div>

    <div id="exitTasksWrapper" class="mt-2 hidden">
        <label class="block text-sm">List All Exit Clearance Tasks</label>
        <textarea name="exit_clearance_tasks" rows="2" class="w-full rounded border-gray-300 px-3 py-2"></textarea>
    </div>

    <div>
        <label class="block text-sm">Proof from Team/Group Leader</label>
        <input type="file" name="file_leader_confirmation" class="w-full rounded border-gray-300">
    </div>
    <div>
        <label class="block text-sm">Proof from HR</label>
        <input type="file" name="file_hr_confirmation" class="w-full rounded border-gray-300">
    </div>
    <div>
        <label class="block text-sm">E-signature File</label>
        <input type="file" name="esignature_exit_file" class="w-full rounded border-gray-300">
    </div>
</div>
