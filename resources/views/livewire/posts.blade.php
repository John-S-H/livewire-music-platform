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

                <select wire:model="selectedProvince" class="bg-white shadow rounded border-0 p-0 mb-8">
                    <option value="">Selecteer provincie</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province }}">{{ $province }}</option>
                    @endforeach
                </select>
            
                <select wire:model="selectedType" class="bg-white shadow rounded border-0 p-0 mb-8">
                    <option value="">Selecteer Type</option>
                    @foreach ($types as $type)
                        <option value="{{ strtolower($type) }}">{{ $type }}</option>
                    @endforeach
                </select>

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
                <x-input id="title" type="text" class="mt-1 block w-full" wire:model.defer="post.title" required autocomplete="title" />
                <x-input-error for="post.title" class="mt-2" />
            </div>
    
            <div class="col-span-6 sm:col-span-4 mb-4">
                <x-label for="description" value="{{ __('Omschrijving') }}" />
                <x-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="post.description" required autocomplete="description" />
                <x-input-error for="post.description" class="mt-2" />
            </div>
    
            <div class="col-span-6 sm:col-span-4 mb-4">
                <x-label for="province" value="{{ __('Province') }}" />
                <select id="province" wire:model.defer="post.province" class="mt-1 block w-full" required>
                    <option value="" selected disabled>Select Province</option>
                    <option value="Groningen">Groningen</option>
                    <option value="Fryslân">Fryslân</option>
                    <option value="Drenthe">Drenthe</option>
                    <option value="Overijssel">Overijssel</option>
                    <option value="Gelderland">Gelderland</option>
                    <option value="Flevoland">Flevoland</option>
                    <option value="Utrecht">Utrecht</option>
                    <option value="Noord-Holland">Noord-Holland</option>
                    <option value="Zuid-Holland">Zuid-Holland</option>
                    <option value="Zeeland">Zeeland</option>
                    <option value="Noord-Brabant">Noord-Brabant</option>
                    <option value="Limburg">Limburg</option>
                </select>
                <x-input-error for="post.province" class="mt-2" />
            </div>
    
            <div class="col-span-6 sm:col-span-4 mb-4">
                <x-label for="type" value="{{ __('Type') }}" />
                <select id="type" wire:model.defer="post.type" class="mt-1 block w-full" required>
                    <option value="" selected disabled>Select Type</option>
                    <option value="Bassist">Bassist</option>
                    <option value="Blokfluitist">Blokfluitist</option>
                    <option value="Cellist">Cellist</option>
                    <option value="Componist">Componist</option>
                    <option value="Rapper">Rapper</option>
                    <option value="Drummer">Drummer</option>
                    <option value="Fluitist">Fluitist</option>
                    <option value="Gitarist">Gitarist</option>
                    <option value="Harpist">Harpist</option>
                    <option value="Hoboïst">Hoboïst</option>
                    <option value="Hoornist">Hoornist</option>
                    <option value="Klavecinist">Klavecinist</option>
                    <option value="Klarinettist">Klarinettist</option>
                    <option value="Organist">Organist</option>
                    <option value="Percussionist">Percussionist</option>
                    <option value="Pianist">Pianist</option>
                    <option value="Saxofonist">Saxofonist</option>
                    <option value="Toetsenist">Toetsenist</option>
                    <option value="Trombonist">Trombonist</option>
                    <option value="Trompettist">Trompettist</option>
                    <option value="Tubaïst">Tubaïst</option>
                    <option value="Violist">Violist</option>
                    <option value="Zanger">Zanger</option>
                </select>
                <x-input-error for="post.type" class="mt-2" />
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
 