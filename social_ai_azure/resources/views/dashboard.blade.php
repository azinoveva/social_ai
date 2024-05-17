<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Entries') }} <span class="text-gray-400">({{ $entries->count() }})</span>
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">

    <form class="flex w-full max-w-sm space-x-3">
        <input 
            type="text" 
            name="q"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500" 
            placeholder="What are you looking for?"
            value="{{ request('q') }}"
        >
        <button 
            type="submit" 
            class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
        >
            Search
        </button>
    </form> 
    @if (request()->has('q'))
        <p class="text-sm">Using search: <strong>"{{ request('q') }}"</strong>. <a class="border-b border-indigo-800 text-indigo-800" href="{{ route('keyword-search') }}">Clear filters</a></p>
    @endif
    </div>

    <div class="py-12">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 bg-white border-b border-gray-200">
                     <div class="mt-8 space-y-8">
                         @forelse ($entries as $entry)
                             <article class="space-y-1">
                                 <h2 class="font-semibold text-2xl">{{ $entry->title }}</h2>
                                 <p class="m-0">{{ $entry->body }}</body>
                                 <div>
                                     @foreach ($entry->tags as $tag)
                                         <span class="text-xs px-2 py-1 rounded bg-indigo-50 text-indigo-500">{{ $tag}}</span>
                                     @endforeach
                                 </div>
                             </article>
                         @empty
                             <p>No articles found</p>
                         @endforelse
                     </div>
                 </div>
             </div>
         </div>
     </div>
</x-app-layout>
