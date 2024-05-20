<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
        {{ __('Angebote') }}
        </h2>
    </x-slot>

    <div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8">

    <form class="flex w-full space-x-3">
        <input 
            type="text" 
            name="q"
            class="w-2/3 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-sky-800" 
            placeholder="Wie kann ich Ihnen helfen?"
            value="{{ request('q') }}"
        >
        <div class="relative w-1/3">
        <select 
            name="primary_topic" 
            id="primary_topic" 
            class="appearance-none block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-sky-800"
        >
            <option value="">Nach Thema filtern</option>
            @foreach ($primaryTopics as $topic)
                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
            @endforeach
            @if (request()->filled('primary_topic'))
                <option value="{{ request('primary_topic') }}" selected>{{ \App\Models\PrimaryTopic::find(request('primary_topic'))->name }}</option>
            @endif
        </select>
    </div>
        <button 
            type="submit" 
            class="px-4 py-2 text-white bg-sky-700 rounded-md hover:bg-sky-800 focus:outline-none focus:bg-sky-800"
        >
            Search
        </button>
    </form> 

    @if (request()->filled('q'))
        <p class="text-sm">Mit Suchanfrage: <strong>"{{ request('q') }}"</strong>. <a class="border-b border-cyan-800 text-cyan-800" href="{{  url()->current() }}">Suche löschen</a></p>

        @if(Str::contains(url()->current(), 'semantic'))
            <p class="text-sm">Filtern Sie nach folgenden Themen: <strong>{{ $primaryTags }}</strong>.
            <p class="text-sm">Fügen Sie folgende Schlüsselwörter hinzu: <strong> {{ $tags }}</strong>.
        @endif
    @endif
    </div>

    <div class="pb-12">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="px-6 bg-white border-b border-gray-200">
                     <div class="mt-8 space-y-8">
                         @forelse ($entries as $entry)
                             <article class="space-y-1">
                                 <h2 class="font-semibold text-2xl">{{ $entry->title }} <span class="text-sm px-2 py-1 rounded bg-sky-50 text-sky-700"> {{$entry->primaryTopic->name }} </span> </h2> 
                                 <p class="m-0">{{ $entry->body }}</body>
                                 <div>
                                     @foreach ($entry->tags()->get() as $tag)
                                         <span class="text-xs px-2 py-1 rounded bg-cyan-50 text-cyan-700">{{ $tag->name }}</span>
                                     @endforeach
                                 </div>
                             </article>
                         @empty
                             <p>No articles found</p>
                         @endforelse
                         {{$entries->links()}}
                     </div>
                 </div>
             </div>
         </div>
     </div>
</x-app-layout>
