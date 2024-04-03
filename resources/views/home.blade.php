<x-layout>
    <x-slot:heading>Home</x-slot:heading>
    <?php // dd($user); ?>
    <div class="container-fluid">
        <table class="table table-striped">
            <thead>
                <th>Name</th>
                @for ($i = 1; $i < 31; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </thead>
            <tbody>
                @foreach ($user as $item)
                    <tr>
                        <td>{{ $item->firstName }} {{ $item->lastName }}</td>
                        @for ($i = 1; $i < 31; $i++)
                            <td>
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>