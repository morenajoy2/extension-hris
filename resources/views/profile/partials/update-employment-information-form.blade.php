<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Employment Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's employment information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="employee_id" :value="__('Employee ID')" />
            <x-text-input id="employee_id" name="employee_id" type="number" class="mt-1 block w-full"
                :value="old('employee_id', $user->employee_id)" required autocomplete="employee_id" />
            <x-input-error class="mt-2" :messages="$errors->get('employee_id')" />
        </div>

        <div>
            <x-input-label for="employment_type_id" :value="__('Employment Type')" />
            <select id="employment_type_id" name="employment_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach ($employmentTypes as $type)
                    <option value="{{ $type->id }}" @selected($user->employment_type_id == $type->id)>
                        {{ $type->type }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('employment_type_id')" />
        </div>

        <div>
            <x-input-label for="role_id" :value="__('Role')" />
            <select id="role_id" name="role_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                        {{ $role->role }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('role_id')" />
        </div>

        <div>
            <x-input-label for="department_id" :value="__('Department')" />
            <select id="department_id" name="department_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" @selected($user->department_id == $dept->id)>
                        {{ $dept->department_name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('department_id')" />
        </div>

        <div>
            <x-input-label for="department_team_id" :value="__('Department Team')" />
            <select id="department_team_id" name="department_team_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach ($departmentTeams as $team)
                    <option value="{{ $team->id }}" @selected($user->department_team_id == $team->id)>
                        {{ $team->team_name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('department_team_id')" />
        </div>

        <div>
            <x-input-label for="position_id" :value="__('Position')" />
            <select id="position_id" name="position_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}" @selected($user->position_id == $position->id)>
                        {{ $position->position_name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('position_id')" />
        </div>

        <div>
            <x-input-label for="group_no" :value="__('Group Number')" />
            <select id="group_no" name="group_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @foreach ($groups as $group)
                    <option value="{{ $group->group_no }}" @selected($user->group_no == $group->group_no)>
                        Group {{ $group->group_no }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('group_no')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
