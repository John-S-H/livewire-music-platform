<div class="w-full flex flex-wrap">
    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
        <div class="mt-8 text-2xl flex justify-between">
            <div>Muzikant types</div>
            @if ($musicianTypes)
                @foreach ($musicianTypes as $type)
                    <p>{{ $type->name }}</p>
                @endforeach
            @else
                <p>Geen muzikan types gevonden.</p>
            @endif
        </div>
    </div>
</div>

