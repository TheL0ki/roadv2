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
                                <img src="{{ $user->profilePic }}" class="w-[30px] h-[30px] rounded-full">
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
                        <x-table.head-cell class="border border-white/20" :$loopdate>
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
                        <x-table.body-cell class="text-center" :$loopdate>
                            <x-form.select name="shift[{{ $i }}][shift]">
                                @php
                                    $todayShift = $user->schedule->where('day', $loopdate->format('d'))->where('month', $loopdate->format('m'))->where('year', $loopdate->format('Y'))->first();
                                @endphp
                                @if ($todayShift)
                                    <option value="{{ $todayShift->shift->id }}">{{ $todayShift->shift->display }}</option>
                                @endif
                                <option value="null">--</option>
                                @foreach ($user->team->shift as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->display }}</option>
                                @endforeach
                            </x-form.select>
                            HO: <input type="checkbox" name="shift[{{ $i }}][homeOffice]" value="1">
                        </x-table.body-cell>
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
                        <x-table.head-cell class="border border-white/20" :$loopdate>
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
                        <x-table.body-cell class="text-center" :$loopdate>
                            <x-form.select name="shift[{{ $i }}][shift]">
                                @php
                                    $todayShift = $user->schedule->where('day', $loopdate->format('d'))->where('month', $loopdate->format('m'))->where('year', $loopdate->format('Y'))->first();
                                @endphp
                                @if ($todayShift)
                                    <option value="{{ $todayShift->shift->id }}">{{ $todayShift->shift->display }}</option>
                                @endif
                                <option value="null">--</option>
                                @foreach ($user->team->shift as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->display }}</option>
                                @endforeach
                            </x-form.select>
                            HO: <input type="checkbox" name="shift[{{ $i }}][homeOffice]" value="1">
                        </x-table.body-cell>
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