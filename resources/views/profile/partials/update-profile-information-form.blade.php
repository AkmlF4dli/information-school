<section>
    <a href="{{ route('dashboard') }}"
        class="mb-10 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md 
               font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 
               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        &larr; Back to Dashboard
    </a>

    <header>
        <h2 class="text-lg font-medium text-grey-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-grey-700">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        
        <!-- Preview Area -->
    @if (Auth::user()->picture == '/storage/profile/profile.jpg')
    <div>
        <img id="imagePreview" src="{{ Auth::user()->picture }}" alt="Preview"
             class="w-32 h-32 rounded-full object-cover border border-gray-300 shadow">
    </div>
    @else 
    <div>
        <img id="imagePreview" src="/storage/{{ Auth::user()->picture }}" alt="Preview"
             class="w-32 h-32 rounded-full object-cover border border-gray-300 shadow">
    </div>
    @endif

    <!-- Delete Profile Picture Button -->
<div class="mt-1">
    <a href="{{ url('/delete/picture') }}"
       onclick="return confirm('Are you sure you want to delete your profile picture?');"
       class="inline-block px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-md hover:bg-red-700 transition">
        Delete Profile Picture
    </a>
</div>

    <!-- File Input -->
    <input type="file" id="imageInput" accept="image/*"
           class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                  file:rounded-full file:border-0 file:text-sm file:font-semibold
                  file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" name="picture">
</div>

        <div class="mt-2">
            <x-input-label for="name" :value="__('Name')" class="text-blue-900" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500" 
                          :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-blue-700" :messages="$errors->get('name')" />
        </div>

        <div class="mt-2">
            <x-input-label for="email" :value="__('Email')" class="text-blue-900" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-blue-300 focus:border-blue-500 focus:ring-blue-500"
                          :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-blue-700" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-blue-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-blue-600 hover:text-blue-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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

        <div class="mt-2 flex items-center gap-4">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-blue-700"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>


