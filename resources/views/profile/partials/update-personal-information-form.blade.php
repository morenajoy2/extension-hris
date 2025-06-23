<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Personal Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus autocomplete="first_name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

         <div>
            <x-input-label for="middle_name" :value="__('Middle Name')" />
            <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name', $user->middle_name)" autofocus autocomplete="middle_name" />
            <x-input-error class="mt-2" :messages="$errors->get('middle_name')" />
        </div>

         <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required autofocus autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div>
            <x-input-label for="birth_of_date" :value="__('Birthdate')" />
            <x-text-input id="birth_of_date" name="birth_of_date" type="date" class="mt-1 block w-full" :value="old('birth_of_date', $user->birth_of_date)" required autofocus autocomplete="birth_of_date" />
            <x-input-error class="mt-2" :messages="$errors->get('birth_of_date')" />
        </div>

        <div>
            <x-input-label for="contact_number" :value="__('Contact Number')" />
            <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" :value="old('contact_number', $user->contact_number)" required autofocus autocomplete="contact_number" />
            <x-input-error class="mt-2" :messages="$errors->get('contact_number')" />
        </div>

        <div>
            <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Permanent Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" required autofocus autocomplete="address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="school" :value="__('School')" />
            <x-text-input id="school" name="school" type="text" class="mt-1 block w-full" :value="old('school', $user->school)" required autofocus autocomplete="school" />
            <x-input-error class="mt-2" :messages="$errors->get('school')" />
        </div>

        <div>
            <x-input-label for="school_address" :value="__('School Address')" />
            <x-text-input id="school_address" name="school_address" type="text" class="mt-1 block w-full" :value="old('school_address', $user->school_address)" required autofocus autocomplete="school_address" />
            <x-input-error class="mt-2" :messages="$errors->get('school_address')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
