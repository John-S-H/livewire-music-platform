<div class="p-6 sm:px-20 bg-white border-b border-gray-200">

    @if(session()->has('message'))
        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 relative" role="alert" x-data="{show: true}" x-show="show">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
            <p>{{ session('message') }}</p>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="show = false">
                <svg class="fill-current h-6 w-6 text-white-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
        </div>
    @endif

    <div class="mt-8 text-2xl flex justify-between">
        <div>Posts</div>
        <div class="mr-2">
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
                <input wire:model.debounce.500ms="q" type="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 mr-4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Zoek..">

                <select id="provinces" wire:model="selectedProvince" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mr-4 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Selecteer provincie</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province }}">{{ $province }}</option>
                    @endforeach
                </select>
            
                <select wire:model="selectedType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        <td class="border px-4 py-2">
                            <button wire:click="confirmPostEdit({{ $post->id }})" class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">
                                {{ __('Aanpassen') }}
                            </button>

                            <button  wire:click="confirmPostDeletion({{ $post->id }})" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900" wire:loading.attr="disabled">
                                {{ __('Verwijder') }}
                            </button>

                            <a href="{{ route('view.post', ['id' => $post->id]) }}" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
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
                <x-input id="title" type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-full" wire:model.defer="post.title" required autocomplete="title" />
                <x-input-error for="post.title" class="mt-2" />
            </div>
    
            <div class="col-span-6 sm:col-span-4 mb-4">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Omschrijving') }}</label>
                <textarea id="message" wire:model.defer="post.description" required autocomplete="description" id="description"  rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Vul de omschrijving in..."></textarea>
                <x-input-error for="post.description" class="mt-2" />
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div class="">
                    <x-label for="province" value="{{ __('Province') }}" />
                    <select id="province" wire:model.defer="post.province" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mr-4 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Selecteer provincie</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province }}">{{ $province }}</option>
                        @endforeach
                        <x-input-error for="post.province" class="mt-2" />
                    </select>
                </div>
        
                <div class="">
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
 