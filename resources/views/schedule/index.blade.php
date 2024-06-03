<x-layout>
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell>Name</x-table.head-cell>
                    @php
                        $loopdate = clone $date;
                    @endphp
                    @for ($i = 1; $i <= $date->format('t'); $i++)
                        <x-table.head-cell :$loopdate >
                            {{ $i }}
                        </x-table.head-cell>
                        @php
                            $loopdate->modify('+1 Day');
                        @endphp
                    @endfor
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @php
                    $rowCount = count($user);
                    $counter = 1;
                    $last = false;
                @endphp
                @foreach ($user as $item)
                    @php
                        $loopdate = clone $date;
                        if($counter === $rowCount) {
                            $last = true;
                        }
                    @endphp
                    <x-table.body-row>
                        <x-table.body-cell class="border-l">
                            <a href="/schedule/change/{{ $item->id }}" class="flex">
                                <div>
                                    <img src="{{ $item->profilePic }}" class="w-[30px] h-[30px] rounded-full">
                                </div>
                                <div class="px-2 flex items-center">
                                    {{ $item->firstName }} {{ $item->lastName }}
                                </div>
                            </a>
                        </x-table.body-cell>
                        @for ($i = 1; $i <= $date->format('t'); $i++)
                            <x-table.body-cell class="border-l w-[50px] text-center" :$loopdate :$last >
                                @isset ($table[$item->id][$i])
                                    {{ $table[$item->id][$i]->shift->display }}
                                @endisset
                            </x-table.body-cell>
                            @php
                                $loopdate->modify('+1 Day');                                
                            @endphp
                        @endfor
                    </x-table.body-row>
                    @php
                        $counter++;
                    @endphp
                @endforeach
            </x-table.body>
        </x-table.table>
</x-layout>