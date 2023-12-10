<div>
    <button wire:click="confirmPostEdit(  {{ $postId}})" class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">
        {{ __('Aanpassen') }}
    </button>

    <button wire:click="confirmPostDeletion( {{ $postId}})" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
        {{ __('Delete') }}
    </button>

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
                    <x-label for="province" value="{{ __('ProvinceSeeder') }}" />
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
