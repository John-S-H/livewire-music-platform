<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $post->title }}
    </h2>
</x-slot>

<div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-session-message/>

            <div class="flex justify-between items-center my-4 mx-4">
                <h1 class="text-3xl font-extrabold leading-tight text-gray-700 lg:text-4xl">{{ $post->title }}</h1>
                <div>
                    @if($this->checkOwner($post->user_id))
                        <a href="#" wire:click.prevent="confirmPostEdit({{ $post->id }})"
                           class="link-warning link-hover mr-2">
                            <i class="bi bi-pencil text-lg"></i>
                        </a>
                        <a href="#" wire:click="confirmPostDeletion({{ $post->id }})" class="link-error link-hover">
                            <i class="bi bi-trash text-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
            <hr>

            <div class="pb-16 lg:pb-24 bg-white">

                <div class="flex justify-center items-center  px-4 mx-auto max-w-screen-xl ">
                    <div class="mx-auto w-full max-w-6xl format format-sm sm:format-base lg:format-lg format-blue">
                        <header class="my-4">
                            <address class="flex items-center not-italic">
                                <div class="inline-flex items-center mr-3 text-sm text-gray-900">
                                    <img class="mr-4 w-16 h-16 rounded-full" src="{{ $author->profile_photo_url }}"
                                         alt="{{ Auth::user()->name }}">
                                    <div>
                                        <a href="#" rel="author"
                                           class="text-xl font-bold text-gray-900">{{ $author->name }}</a>
                                        <p class="text-base font-light text-gray-500">{{ $author->email }}</p>
                                        <p class="text-base font-light text-gray-500">
                                            <time pubdate datetime="2022-02-08"
                                                  title="{{ $post->created_at }}">{{ $post->created_at }}</time>
                                        </p>
                                    </div>
                                </div>
                            </address>

                        </header>
                        <div class="my-2">
                            <h5 class="text-2xl">{{ $author->name }} zoekt een <b>{{ $post->type }} </b> in
                                <b> {{ $post->province }}</b></h5>
                        </div>
                        <div>
                            <p>{{ $post->description }}</p>
                        </div>

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
                        <x-secondary-button wire:click="$set('confirmingPostDeletion', false)"
                                            wire:loading.attr="disabled">
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
                            <x-label for="title" value="{{ __('Title') }}"/>
                            <x-input id="title" type="text" class="input input-bordered w-full"
                                     wire:model.defer="post.title"
                                     required autocomplete="title"/>
                            <x-input-error for="post.title" class="mt-2"/>
                        </div>

                        <div class="col-span-6 sm:col-span-4 mb-4">
                            <label for="message"
                                   class="block mb-2 text-sm font-medium text-gray-900">{{ __('Omschrijving') }}</label>
                            <textarea id="message" wire:model.defer="post.description" required
                                      autocomplete="description"
                                      id="description" rows="4" class="textarea textarea-bordered w-full"
                                      placeholder="Vul de omschrijving in..."></textarea>
                            <x-input-error for="post.description" class="mt-2"/>
                        </div>

                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <x-label for="province" value="{{ __('Province') }}"/>
                                <select id="province" wire:model.defer="post.province"
                                        class="select select-bordered w-full max-w-x w-full">
                                    <option value="">Selecteer provincie</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province }}">{{ $province }}</option>
                                    @endforeach
                                    <x-input-error for="post.province" class="mt-2"/>
                                </select>
                            </div>

                            <div>
                                <x-label for="type" value="{{ __('Type') }}"/>
                                <select id="type" wire:model.defer="post.type"
                                        class="select select-bordered w-full max-w-x w-full">
                                    <option value="" selected disabled>Select Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="post.type" class="mt-2"/>
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

                        <button class="ml-3 btn btn-info" wire:click="savePost()" wire:loading.attr="disabled">
                            {{ __('Opslaan') }}
                        </button>
                    </x-slot>
                </x-dialog-modal>
            </div>
