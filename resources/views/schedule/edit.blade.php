<x-layout>
    <form action="/schedule/{{ $user->id }}/update" method="POST">
        @csrf
        @method('PATCH')
        <div class="space-y-2">
            <x-table.table>
                <x-table.body-row>
                    <x-table.head-cell rowspan="4">
                        <div class="flex">
                            <div>
                                <img src="{{ Vite::asset('storage/app/' . $user->profilePic) }}" class="w-[50px] h-[50px] rounded-full">
                            </div>
                            <div class="px-2 flex items-center">
                                {{ $user->firstName }} {{ $user->lastName }}
                            </div>
                        </div>
                    </x-table.head-cell>
                    @php
                        $loopdate = clone $date;
                    @endphp
                    @for ($i = 1; $i <= 15; $i++)
                        <x-table.head-cell class="border border-white/20 w-[100px]" :$loopdate>
                            {{ $i }}
                        </x-table.head-cell>
                        @php
                            $loopdate->modify('+1 Day');
                        @endphp
                    @endfor
                </x-table.body-row>
                <x-table.body-row>
                    @php
                        $loopdate = clone $date;
                    @endphp
                    @for ($i = 1; $i <= 15; $i++)
                        <x-shiftSelector :$shifts :$loopdate :$i :$user></x-shiftSelector>
                        @php
                            $loopdate->modify('+1 Day');
                        @endphp
                    @endfor
                </x-table.body-row>
                <x-table.body-row>
                    @php
                        $loopdate = clone $date;
                        $loopdate->modify('+15 Days');
                    @endphp
                    @for ($i = 16; $i <= $date->format('t'); $i++)
                        <x-table.head-cell class="border border-white/20 w-[100px]" :$loopdate>
                            {{ $i }}
                        </x-table.head-cell>
                        @php
                            $loopdate->modify('+1 Day');
                        @endphp
                    @endfor
                </x-table.body-row>
                <x-table.body-row>
                    @php
                        $loopdate = clone $date;
                        $loopdate->modify('+15 Days');
                    @endphp
                    @for ($i = 16; $i <= $date->format('t'); $i++)
                        <x-shiftSelector :$shifts :$loopdate :$i :$user></x-shiftSelector>
                        @php
                            $loopdate->modify('+1 Day');
                        @endphp
                    @endfor
                </x-table.body-row>
            </x-table.table>
            <x-button>Save</x-button>
        </div>
        <input type="hidden" value="{{ $user->id }}" name="user_id">
        <input type="hidden" value="{{ $date->format('m') }}" name="month">
        <input type="hidden" value="{{ $date->format('Y') }}" name="year">
    </form>
</x-layout>