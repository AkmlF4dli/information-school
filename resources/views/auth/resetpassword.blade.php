<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-white to-blue-100 px-4">
        <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-md transform transition-all duration-300 hover:scale-[1.02]">

            <!-- Logo -->
            <div class="flex justify-center mb-6">
        <a href="/" ><div class="mb-6 text-center">
            <img src="https://smkn8jakarta.sch.id/wp-content/uploads/2019/12/SMK-N-8-JAKARTA.png" alt="Logo SMKN 8 Jakarta" class="w-20 h-20 mx-auto">
        </div></a>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-blue-800 mb-4 animate-fade-in-down">Lupa Password?</h2>
            <p class="text-gray-600 text-sm text-center mb-6">Masukkan email Anda untuk menerima link reset password.</p>

            <!-- Success Message -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password-reset-post') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="w-full animate-fade-in-up">
                        {{ __('Kirim Link Reset') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <!-- Animasi -->
    <style>
        @keyframes fade-in-down {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.5s ease-out;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.5s ease-out;
        }
    </style>
</x-app-layout>
