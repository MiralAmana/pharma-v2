<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Nom complet') }}</label>
            <input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                   type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                   type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="telephone" class="block font-medium text-sm text-gray-700">{{ __('Numéro de téléphone') }}</label>
            <input id="telephone" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                   type="text" name="telephone" :value="old('telephone')" required placeholder="Ex: 77 123 45 67" />
            <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="adresse" class="block font-medium text-sm text-gray-700">{{ __('Adresse de livraison') }}</label>
            <textarea id="adresse" name="adresse" rows="2" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required placeholder="Quartier, Rue, Ville...">{{ old('adresse') }}</textarea>
            <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Mot de passe') }}</label>
            <input id="password" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                   type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirmer le mot de passe') }}</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                   type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-green-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>

            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __("S'inscrire") }}
            </button>
        </div>
    </form>
</x-guest-layout>