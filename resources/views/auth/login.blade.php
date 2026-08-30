<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full rounded-xl border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Mot de passe') }}</label>
            <input id="password" class="block mt-1 w-full rounded-xl border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                   type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-sky-600 shadow-sm focus:ring-sky-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-gray-500 hover:text-sky-700" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @else
                <span></span>
            @endif

            <button type="submit" class="rounded-full text-sm font-bold text-white px-6 py-2.5 transition bg-sky-600 hover:bg-sky-700">
                {{ __('Se connecter') }}
            </button>
        </div>
    </form>
</x-guest-layout>
