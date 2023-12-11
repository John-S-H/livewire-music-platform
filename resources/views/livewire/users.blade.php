<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Muziekant type</th>
                    <th>Provincie</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th>{{ $user->name }}</th>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->musicianType->name }}</td>
                        <td>{{ $user->province->title }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
