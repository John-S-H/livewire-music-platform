<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2xl">
        Posts
    </div>

    <div class="mt-6">
        <div class="flex justify-between">
            <div></div>
            <div class="mr-2">  
                <input type="checkbox" class="mr-2 leading-tight" wire:model="active" /> Alleen actief

        
            </div>
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">
                        <div class="flex items-center">
                            Id
                        </div>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                Titel
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                Provincie
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                Status
                            </div>
                        </th>
                        <th class="px-4 py-2">
                            <div class="flex items-center">
                                Type
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
                        <td class="border px-4 py-2">
                            {{ $post->status ? 'Actief' : 'Niet actief' }}
                        </td>
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
 