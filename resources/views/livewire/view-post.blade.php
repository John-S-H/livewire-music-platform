
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $post->title }}
    </h2>
</x-slot>

<div class="py-12">
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            @if(session()->has('message'))
            <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert" x-data="{show: true}" x-show="show">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium">
                    {{ session('message') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close" @click="show = false">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
          </div>
        @endif

        <div class="flex justify-between items-center my-4 mx-4">
            
            <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">{{ $post->title }}</h1>
            <div>
                @if($this->checkOwner($post->user_id))
                    <button wire:click="confirmPostEdit({{ $post->id }})" class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">
                        {{ __('Aanpassen') }}
                    </button>

                    <button  wire:click="confirmPostDeletion({{ $post->id }})" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900" wire:loading.attr="disabled">
                        {{ __('Verwijder') }}
                    </button>
                @endif
            </div>
        </div>

        <main class="pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900">
            
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


    <x-confirmation-modal wire:model="confirmingPostDeletion">
        <x-slot name="title">
            {{ __('Verwijder bericht') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Weet je zeker dat je dit bericht wilt verwijderen?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingPostDeletion', false)" wire:loading.attr="disabled">
                {{ __('Annuleren') }}
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deletePost({{ $confirmingPostDeletion }})" wire:loading.attr="disabled">
                {{ __('Verwijder') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>


    <x-dialog-modal wire:model="confirmingPostAdd">
        <x-slot name="title">
            {{ isset($this->post->id) ? 'Post aanpassen' : 'Post toevoegen'}}
        </x-slot>
    
        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 mb-4">
                <x-label for="title" value="{{ __('Title') }}" />
                <x-input id="title" type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full" wire:model.defer="post.title" required autocomplete="title" />
                <x-input-error for="post.title" class="mt-2" />
            </div>
    
            <div class="col-span-6 sm:col-span-4 mb-4">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Omschrijving') }}</label>
                <textarea id="message" wire:model.defer="post.description" required autocomplete="description" id="description"  rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Vul de omschrijving in..."></textarea>
                <x-input-error for="post.description" class="mt-2" />
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <x-label for="province" value="{{ __('Province') }}" />
                    <select id="province" wire:model.defer="post.province" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mr-4 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Selecteer provincie</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province }}">{{ $province }}</option>
                        @endforeach
                        <x-input-error for="post.province" class="mt-2" />
                    </select>
                </div>
        
                <div>
                    <x-label for="type" value="{{ __('Type') }}" />
                    <select id="type" wire:model.defer="post.type" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mr-4 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected disabled>Select Type</option>
                        @foreach ($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="post.type" class="mt-2" />
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <label class="flex items-center">
                    <input type="checkbox" wire:model.defer="post.status" class="form-checkbox">
                    <span class="ml-2 text-sm text-gray-600">Actief</span>
                </label>
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingPostAdd', false)" wire:loading.attr="disabled">
                {{ __('Annuleren') }}
            </x-secondary-button>
    
            <x-danger-button class="ml-3" wire:click="savePost()" wire:loading.attr="disabled">
                {{ __('Opslaan') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>