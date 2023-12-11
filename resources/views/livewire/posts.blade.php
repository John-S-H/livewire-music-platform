<div class="p-6 sm:px-20 bg-white border-b border-gray-200">

    <x-session-message/>

    <div class="mt-8 flex justify-between">
        <div>Posts</div>
        <div class="mr-2">
            <a href="#" wire:click="confirmPostAdd" class="link-info link-hover">
                {{ __('Nieuwe post') }}
            </a>
        </div>
    </div>

    <div class="mt-6">

        <div class="flex justify-between mb-4">
            <div>
                <input wire:model.debounce.500ms="q" type="search" class="input input-bordered max-w-xs mr-4"
                       placeholder="Zoek..">

                <select id="provinces" wire:model="selectedProvince" class="select select-bordered max-w-xs mr-4">
                    <option value="">Selecteer provincie</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->title }}">{{ $province->title }}</option>
                    @endforeach
                </select>

                <select wire:model="selectedType" class="select select-bordered max-w-xs">
                    <option value="">Selecteer type muziekant</option>
                    @foreach ($types as $type)
                        <option value="{{ strtolower($type->name) }}">{{ $type->name }}</option>
                    @endforeach
                </select>

            </div>
            <div class="mr-2">
                <input type="checkbox" class="mr-2 leading-tight" wire:model="active"/> Alleen actief
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('id')">Id</button>
                            <x-sort-icon sortField="id" :sortBy="$sortBy" :sortAsc="$sortAsc"/>
                        </div>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <p>Gebruiker</p>
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('title')">Title</button>
                            <x-sort-icon sortField="title" :sortBy="$sortBy" :sortAsc="$sortAsc"/>
                        </div>
                    </th>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('province')">Provincie</button>
                            <x-sort-icon sortField="province" :sortBy="$sortBy" :sortAsc="$sortAsc"/>
                        </div>
                    </th>

                    @if(!$active)
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('status')">Status</button>
                                <x-sort-icon sortField="status" :sortBy="$sortBy" :sortAsc="$sortAsc"/>
                            </div>
                        </th>
                    @endif

                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            <button wire:click="sortBy('type')">Type</button>
                            <x-sort-icon sortField="type" :sortBy="$sortBy" :sortAsc="$sortAsc"/>
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
                        @if(isset($post->user->profile_photo_url))
                            <td class="border px-4 py-2">
                                <div class="avatar">
                                    <div class="w-12 mask mask-squircle">
                                        <img src="{{ $post->user->profile_photo_url }}"/>
                                    </div>
                                </div>
                            </td>
                        @endif

                        <td class="border px-4 py-2">
                            {{ $post->title }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $post->province->title }}
                        </td>
                        @if(!$active)
                            <td class="border px-4 py-2">
                                {{ $post->status ? 'Actief' : 'Niet actief' }}
                            </td>
                        @endif
                        <td class="border px-4 py-2">
                            {{ $post->musicianType->name }}
                        </td>
                        <td class="border px-4 py-2 my-2">
                            @if($this->checkOwner($post->user_id))

                                <a href="#" wire:click.prevent="confirmPostEdit({{ $post->id }})"
                                   class="link-warning link-hover">
                                    <i class="bi bi-pencil text-lg"></i>
                                </a>

                                <a href="#" wire:click="confirmPostDeletion({{ $post->id }})"
                                   class="link-error link-hover">
                                    <i class="bi bi-trash text-lg"></i>
                                </a>
                            @endif

                            <a href="{{ route('view.post', ['id' => $post->id]) }}" class="link-info link-hover">
                                <i class="bi bi-eye text-lg"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
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

            <x-danger-button class="ml-3" wire:click="deletePost({{ $confirmingPostDeletion }})"
                             wire:loading.attr="disabled">
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
                <x-label for="title" value="{{ __('Titel') }}"/>
                <x-input id="title" type="text" class="input input-bordered w-full "
                         wire:model.defer="post.title" required autocomplete="title"/>
                <x-input-error for="post.title" class="mt-2"/>
            </div>

            <div class="col-span-6 sm:col-span-4 mb-4">
                <label for="message"
                       class="block mb-2 text-sm font-medium text-gray-900">{{ __('Omschrijving') }}</label>
                <textarea id="message" wire:model.defer="post.description" required autocomplete="description"
                          id="description" rows="4" class="textarea textarea-bordered w-full"
                          placeholder="Vul de omschrijving in..."></textarea>
                <x-input-error for="post.description" class="mt-2"/>
            </div>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <x-label for="province_id" value="{{ __('Provincie') }}"/>
                    <select id="province_id" wire:model.defer="post.province_id"
                            class="select select-bordered w-full max-w-xs">
                        <option value="">Selecteer provincie</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->title }}</option>
                        @endforeach
                        <x-input-error for="post.province_id" class="mt-2"/>
                    </select>
                </div>

                <div>
                    <x-label for="musician_type_id" value="{{ __('Muziekant type') }}"/>
                    <select id="musician_type_id" wire:model.defer="post.musician_type_id" class="select select-bordered w-full max-w-xs">
                        <option value="" selected disabled>Select Muziek type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="post.musician_type_id" class="mt-2"/>
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
