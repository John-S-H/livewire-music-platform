<div class="p-6 sm:px-20 bg-white border-b border-gray-200">

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

    <div class="mt-8 text-2xl flex justify-between">
        <div>Posts</div>
        <div class="mr-2">a
            <button wire:click="confirmPostAdd" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                {{ __('Nieuwe post') }}
            </button>
        </div>
    </div>

    {{-- User for checking the query --}}
    {{-- {{ $sqlQuery }} --}}

    <div class="mt-6">
        
        <div class="flex justify-between mb-4">
            <div>
                <input wire:model.debounce.500ms="q" type="search" class="input input-bordered max-w-xs mr-4" placeholder="Zoek..">

                <select id="provinces" wire:model="selectedProvince" class="select select-bordered max-w-xs mr-4">
                    <option value="">Selecteer provincie</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province }}">{{ $province }}</option>
                    @endforeach
                </select>
            
                <select wire:model="selectedType" class="select select-bordered max-w-xs">
                    <option value="">Selecteer type muziekant</option>
                    @foreach ($types as $type)
                        <option value="{{ strtolower($type) }}">{{ $type }}</option>
                    @endforeach
                </select>

            </div>
            <div class="mr-2">  
                <input type="checkbox" class="mr-2 leading-tight" wire:model="active" /> Alleen actief
            </div>
        </div>
        <table class="table-auto w-full relative overflow-x-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">Id</button>
                            <x-sort-icon sortField="id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                        </div>
                        <th class="px-4 py-2">
                        <div class="flex items-center">
                            <p>Gebruiker</p>
                        </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('title')">Title</button>
                                <x-sort-icon sortField="title" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('province')">Provincie</button>
                                <x-sort-icon sortField="province" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>

                        @if(!$active)
                            <th class="px-4 py-2">
                                <div class="flex items-center">
                                    <button wire:click="sortBy('status')">Status</button>
                                    <x-sort-icon sortField="status" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                                </div>
                            </th>
                        @endif

                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('type')">Type</button>
                                <x-sort-icon sortField="type" :sortBy="$sortBy" :sortAsc="$sortAsc" />
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                Actie
                            </div>
                        </th>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td class="border px-4 py-2">
                            {{ $post->id }}
                        </td>
                        <td class="border px-4 py-2">
                            <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                                <img class="mr-4 w-12 h-12 rounded-full" src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}">
                            </div>
                        </td>
                        <td class="border px-4 py-2">
                            {{ $post->title }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $post->province }}
                        </td>
                        @if(!$active)
                            <td class="border px-4 py-2">
                                {{ $post->status ? 'Actief' : 'Niet actief' }}
                            </td>
                        @endif
                        <td class="border px-4 py-2">
                            {{ $post->type }}
                        </td>
                        <td class="border px-4 py-2 my-2">
                            @if($this->checkOwner($post->user_id))

                                <a href="#" wire:click.prevent="confirmPostEdit({{ $post->id }})" class="link-warning link-hover">
                                    {{ __('Aanpassen') }}
                                </a>

                                <a href="#"  wire:click="confirmPostDeletion({{ $post->id }})" class="link-error link-hover">
                                    {{ __('Verwijderen') }}
                                </a>
                            @endif
                    
                            <a href="{{ route('view.post', ['id' => $post->id]) }}" class="link-info link-hover">
                                {{ __('Bekijken') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
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
                <x-input id="title" type="text"  class="input input-bordered max-w-xs w-full " wire:model.defer="post.title" required autocomplete="title" />
                <x-input-error for="post.title" class="mt-2" />
            </div>
    
            <div class="col-span-6 sm:col-span-4 mb-4">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900">{{ __('Omschrijving') }}</label>
                <textarea id="message" wire:model.defer="post.description" required autocomplete="description" id="description"  rows="4" class="textarea textarea-bordered w-full" placeholder="Vul de omschrijving in..."></textarea>
                <x-input-error for="post.description" class="mt-2" />
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <x-label for="province" value="{{ __('Province') }}" />
                    <select id="province" wire:model.defer="post.province" class="select select-bordered w-full max-w-xs">
                        <option value="">Selecteer provincie</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province }}">{{ $province }}</option>
                        @endforeach
                        <x-input-error for="post.province" class="mt-2" />
                    </select>
                </div>
        
                <div>
                    <x-label for="type" value="{{ __('Type') }}" />
                    <select id="type" wire:model.defer="post.type" class="select select-bordered w-full max-w-xs">
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
 