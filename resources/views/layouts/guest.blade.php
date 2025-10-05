<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-b from-white to-blue-100 text-gray-800 px-6">
        <!-- Logo -->
        <div class="mb-6 text-center animate-fade-in-down">
            <img src="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" alt="Logo SMKN 8 Jakarta" class="w-20 h-20 mx-auto drop-shadow-md">
            <h1 class="text-2xl font-bold text-blue-700 mt-2">Administrator</h1>
        </div>

        <!-- Status -->
        <x-auth-session-status class="mb-4 animate-fade-in" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="w-full max-w-md bg-white/80 border border-blue-200 p-8 rounded-xl shadow-xl backdrop-blur-sm animate-fade-in-up">
            @csrf

            <!-- Email -->
            <div class="transition-all duration-300">
                <x-input-label for="email" :value="__('Email')" class="text-blue-700" />
                <x-text-input id="email" class="block mt-1 w-full border-blue-300 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 transition-all duration-300">
                <x-input-label for="password" :value="__('Password')" class="text-blue-700" />
                <x-text-input id="password" class="block mt-1 w-full border-blue-300 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ms-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 hover:underline transition-all duration-300" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

            <button type="submit"
               class="ml-3 px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition duration-300">
               {{ __('Log in') }}
            </button>

            </div>
        </form>
    </div>

    <!-- Custom Animations -->
    <style>
        @keyframes fade-in {
            0%   { opacity: 0; }
            100% { opacity: 1; }
        }

        @keyframes fade-in-up {
            0%   { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fade-in-down {
            0%   { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in       { animation: fade-in 0.8s ease-out both; }
        .animate-fade-in-up    { animation: fade-in-up 1s ease-out both; }
        .animate-fade-in-down  { animation: fade-in-down 1s ease-out both; }
    </style>
</x-guest-layout>

