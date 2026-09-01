<nav x-data="{ open: false }" class="glass-nav sticky top-0 z-50" style="font-family:'Figtree',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-11">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('logo.png') }}" alt="Logo Pharmacie" class="w-9 h-9 rounded-xl object-cover">
                    <span class="text-lg font-extrabold"><span style="color:var(--navy);">Pharma</span><span style="color:var(--brand);">Pro</span></span>
                    <span class="text-[11px] font-bold uppercase tracking-wide text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Espace Gérant</span>
                </a>

                <div class="hidden space-x-8 sm:flex text-sm font-semibold">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-sky-700' : 'text-gray-600 hover:text-sky-700' }}">Tableau de bord</a>
                    <a href="{{ route('admin.commandes') }}" class="{{ request()->routeIs('admin.commandes') ? 'text-sky-700' : 'text-gray-600 hover:text-sky-700' }}">Commandes</a>
                    <a href="{{ route('admin.produits.index') }}" class="{{ request()->routeIs('admin.produits.*') ? 'text-sky-700' : 'text-gray-600 hover:text-sky-700' }}">Produits</a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <x-theme-toggle />
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-xs font-extrabold" style="background:var(--brand-hover);">
                                {{ collect(explode(' ', Auth::user()->name))->map(fn($p) => mb_substr($p, 0, 1))->join('') }}
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.commandes')" :active="request()->routeIs('admin.commandes')">
                {{ __('Commandes') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.produits.index')" :active="request()->routeIs('admin.produits.*')">
                {{ __('Produits') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <x-theme-toggle />
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
