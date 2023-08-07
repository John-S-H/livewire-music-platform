<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $post->title }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

        <main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900">
            <div class="flex justify-between px-4 mx-auto max-w-screen-xl ">
                <article class="mx-auto w-full max-w-6xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                    <header class="mb-4 lg:mb-6 not-format">
                        <address class="flex items-center mb-6 not-italic">
                            <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
               
                                <img class="mr-4 w-16 h-16 rounded-full" src="{{ $author->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                                <div>
                                    <a href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white">{{ $author->name }}</a>
                                    <p class="text-base font-light text-gray-500 dark:text-gray-400">{{ $author->email }}</p>
                                    <p class="text-base font-light text-gray-500 dark:text-gray-400"><time pubdate datetime="2022-02-08" title="{{ $post->created_at }}">{{ $post->created_at }}</time></p>
                                </div>
                            </div>
                        </address>
                        <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">{{ $post->title }}</h1>
                    </header>
                    <div class="my-2">
                        <h5 class="text-2xl">{{ $author->name }} zoekt een <b>{{ $post->type }} </b> in <b> {{ $post->province }}</b> </h5>
                    </div>
                    <div >
                        <label>Omschrijving:</label>
                        <hr class="my-2">
                        <p>{{ $post->description }}</p>
                    </div>
      
            </div>
        </main>

        </div>
    </div>
</div>