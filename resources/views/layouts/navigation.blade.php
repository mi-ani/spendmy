<aside class="col-span-2 bg-secondary h-screen sticky top-0 border-r-4 border-stoke">
    <div class="p-4">
        <span class="text-2xl font-bold text-headline">
            <span>Spend</span><span class="text-contrast">my</span>
        </span>
    </div>
    <div class="p-2">
        <div class="flex flex-row justify-center text-sm text-paragraph">
            <span>{{ Auth::user()->name }}</span>
            <span class="px-2">|</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="text-contrast" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    Log out
                </a>
            </form>
        </div>
    </div>
    <nav class="py-4 flex flex-col text-md">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Обзор
        </x-nav-link>
        <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.*')">
            Категории
        </x-nav-link>
        <x-nav-link :href="route('operations.index')" :active="request()->routeIs('operations.*')">
            Операции
        </x-nav-link>
    </nav>
</aside>
