<div class="p-6 sm:px-20 bg-white border-b border-gray-200">


    <div class="mt-8 text-2xl flex justify-between">
        <div>Posts</div>
        <div class="mr-2">
            <x-button wire:click="confirmPostAdd" class="bg-blue-600 hover:bg-blue-800">
                {{ __('Nieuwe post') }}
            </x-button>
        </div>
    </div>

    {{-- User for checking the query --}}
    {{-- {{ $sqlQuery }} --}}

    <div class="mt-6">
        
        <div class="flex justify-between mb-4">
            <div>
                <input wire:model.debounce.500ms="q" type="search" class="bg-purple-white shadow rounded border-0 p-0 mb-8" placeholder="Zoek...">
            </div>
            <div class="mr-2">  
                <input type="checkbox" class="mr-2 leading-tight" wire:model="active" /> Alleen actief
            </div>
        </div>
        <table class="table-auto w-full">
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

                            <x-button wire:click="confirmPostEdit({{ $post->id }})" class="bg-orange-600 hover:bg-orange-800">
                                {{ __('Aanpassen') }}
                            </x-button>


                            <x-danger-button wire:click="confirmPostDeletion({{ $post->id }})" wire:loading.attr="disabled">
                                {{ __('Verwijder') }}
                            </x-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>

    <x-dialog-modal wire:model="confirmingPostDeletion">
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
    </x-dialog-modal>


    <x-dialog-modal wire:model="confirmingPostAdd">
        <x-slot name="title">
           {{ isset($this->post->id) ? 'Post aanpassen' : 'Post toevoegen'}}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4 mb-4">
                <x-label for="title" value="{{ __('Title') }}" />
                <x-input id="title" type="text" class="mt-1 block w-full" wire:model.defer="post.title" required autocomplete="title" />
                <x-input-error for="post.title" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mb-4">
                <x-label for="description" value="{{ __('Omschrijving') }}" />
                <x-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="post.description" required autocomplete="description" />
                <x-input-error for="post.description" class="mt-2" />
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
 