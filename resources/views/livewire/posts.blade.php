<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2xl">
        Posts
    </div>

    {{ $sqlQuery }}
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
                                <button wire:click="sortBy('type')">Title</button>
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
                            Aanpassen verwijderen
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $posts->links() }}
    </div>
</div>
 