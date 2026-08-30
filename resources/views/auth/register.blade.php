<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Nom complet') }}</label>
            <input id="name" class="block mt-1 w-full rounded-xl border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                   type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full rounded-xl border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                   type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="telephone" class="block font-medium text-sm text-gray-700">{{ __('Numéro de téléphone') }}</label>
            <input id="telephone" class="block mt-1 w-full rounded-xl border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                   type="text" name="telephone" :value="old('telephone')" required placeholder="Ex: 77 123 45 67" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="adresse" class="block font-medium text-sm text-gray-700">{{ __('Adresse de livraison') }}</label>
            <textarea id="adresse" name="adresse" rows="2" class="block mt-1 w-full rounded-xl border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500" required placeholder="Quartier, Rue, Ville...">{{ old('adresse') }}</textarea>
            <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Mot de passe') }}</label>
            <input id="password" class="block mt-1 w-full rounded-xl border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                   type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirmer le mot de passe') }}</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-xl border-gray-200 shadow-sm focus:border-sky-500 focus:ring-sky-500"
                   type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm font-semibold text-gray-500 hover:text-sky-700" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>

            <button type="submit" class="rounded-full text-sm font-bold text-white px-6 py-2.5 transition bg-sky-600 hover:bg-sky-700">
                {{ __("S'inscrire") }}
            </button>
        </div>
    </form>
</x-guest-layout>
