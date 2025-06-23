<!-- Application Form Extra Fields -->
<div id="applicationInputs" class="hidden mb-4">
    <div class="space-y-3 max-h-72 overflow-y-auto pr-2">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="contact_number" class="block text-sm font-medium">Contact Number</label>
                <input 
                    type="text" 
                    name="contact_number" 
                    id="contact_number"
                    class="w-full rounded border-gray-300"
                    value="{{ $user->contact_number }}" 
                    required
                >
            </div>

            <div>
                <label for="address" class="block text-sm font-medium">Address</label>
                <input 
                    type="text" 
                    name="address" 
                    id="address"
                    class="w-full rounded border-gray-300" 
                    value="{{ $user->address }}" 
                    readonly
                >
            </div>

            <div>
                <label for="school" class="block text-sm font-medium">School Name</label>
                <input 
                    type="text" 
                    name="school" 
                    id="school"
                    class="w-full rounded border-gray-300" 
                    value="{{ $user->school }}" 
                    readonly
                >
            </div>

            <div>
                <label for="school_address" class="block text-sm font-medium">School Address</label>
                <input 
                    type="text" 
                    name="school_address" 
                    id="school_address"
                    class="w-full rounded border-gray-300" 
                    value="{{ $user->school_address }}" 
                    readonly
                >
            </div>
        </div>
    </div>
</div>
