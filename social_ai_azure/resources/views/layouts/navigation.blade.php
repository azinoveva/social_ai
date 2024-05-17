<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:flex">
                    <x-nav-link :href="route('keyword-search')" :active="request()->routeIs('keyword-search')">
                        {{ __('Keyword Search') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:flex">
                    <x-nav-link :href="route('semantic-search')" :active="request()->routeIs('semantic-search')">
                        {{ __('Semantic Search') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
