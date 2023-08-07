<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2xl flex justify-between">
        <div>Users</div>
        @foreach ($users as $user)
            <img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
            <p>{{ $user->name }}</p>
        @endforeach
    </div>
</div>
 