<x-layout>
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell>Name</x-table.head-cell>
                    @for ($i = 1; $i <= $date->format('t'); $i++)
                        <x-table.head-cell>{{ $i }}</x-table.head-cell>
                    @endfor
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @foreach ($user as $item)
                    <x-table.body-row>
                        <x-table.body-cell><a href="/schedule/change/{{ $item->id }}"> {{ $item->firstName }} {{ $item->lastName }} </a></x-table.body-cell>
                        @for ($i = 1; $i <= $date->format('t'); $i++)
                            <x-table.body-cell class="w-[50px] text-center">
                                @isset ($table[$item->id][$i])
                                    {{ $table[$item->id][$i]->shift->display }}
                                @endisset
                            </x-table.body-cell>
                        @endfor
                    </x-table.body-row>
                @endforeach
            </x-table.body>
        </x-table.table>
</x-layout>