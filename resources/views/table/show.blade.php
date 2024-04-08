<x-layout>
    <x-slot:heading>Home</x-slot:heading>
    <?php // dd($table); ?>
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Name</th>
                    @for ($i = 1; $i <= $date->format('t'); $i++)
                        <th>{{ $i }}</th>
                    @endfor
                </thead>
                <tbody>
                    @foreach ($user as $item)
                        <tr>
                            <td><a href="/schedule/change/{{ $item->id }}"> {{ $item->firstName }} {{ $item->lastName }} </a></td>
                            @for ($i = 1; $i <= $date->format('t'); $i++)
                                <td>
                                    @isset ($table[$item->id][$i])
                                        {{ $table[$item->id][$i]->shift->display }}
                                    @endisset
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>