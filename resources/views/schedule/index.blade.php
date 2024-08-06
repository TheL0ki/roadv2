<x-layout>
    <div class="space-y-4">

        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-6">
                <label for="first-name" class="block text-sm font-medium leading-6">Team</label>
                <div class="mt-2">
                    <x-form.select class="text-start pl-3 rounded-md">
                        @foreach ($teams as $team)
                            <option>{{ $team->displayName }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="first-name" class="block text-sm font-medium leading-6">Month</label>
                <div class="mt-2">
                    <x-form.select class="text-start pl-3 rounded-md" onchange="if (this.value) window.location.href=this.value">
                        @foreach ($months as $key => $month)
                            <option value="/schedule/{{ $date->format('Y') . '/' . $key }}" @if ($key == $date->format('n')) selected="selected" @endif">{{ $month }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </div>

            <div class="sm:col-span-3">
                <label for="last-name" class="block text-sm font-medium leading-6">Year</label>
                <div class="mt-2">
                    <x-form.select class="text-start pl-3 rounded-md" onchange="if (this.value) window.location.href=this.value">
                        <option value="/schedule/{{ $date->format('Y')-2 . '/' . $date->format('n') }}">{{ $date->format('Y')-2 }}</option>
                        <option value="/schedule/{{ $date->format('Y')-1 . '/' . $date->format('n') }}">{{ $date->format('Y')-1 }}</option>
                        <option value="/schedule/{{ $date->format('Y') . '/' . $date->format('n') }}" selected="selected">{{ $date->format('Y') }}</option>
                        <option value="/schedule/{{ $date->format('Y')+1 . '/' . $date->format('n') }}">{{ $date->format('Y')+1 }}</option>
                        <option value="/schedule/{{ $date->format('Y')+2 . '/' . $date->format('n') }}">{{ $date->format('Y')+2 }}</option>
                    </x-form.select>
                </div>
            </div>
        </div>

        @php
            $prevMonth = clone $date;
            $prevMonth->modify('-1 Month');
            $nextMonth = clone $date;
            $nextMonth->modify('+1 Month');
        @endphp

        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <div class="mt-2">
                    <a href="/schedule/{{ $prevMonth->format('Y') . '/' . $prevMonth->format('n') }}"><x-button class="w-full">← {{ $prevMonth->format('F') . ' ' . $prevMonth->format('Y') }}</x-button></a>
                </div>
            </div>

            <div class="sm:col-span-3">
                <div class="mt-2">
                    <a href="/schedule/{{ $nextMonth->format('Y') . '/' . $nextMonth->format('n') }}"><x-button class="w-full">{{ $nextMonth->format('F') . ' ' . $nextMonth->format('Y') }} →</x-button></a>
                </div>
            </div>
        </div>
        <div>
            <x-table.table>
                <x-table.head>
                    <x-table.head-row>
                        <x-table.head-cell>Name</x-table.head-cell>
                        @php
                            $loopdate = clone $date;
                        @endphp
                        @for ($i = 1; $i <= $date->format('t'); $i++)
                            <x-table.head-cell :$loopdate>
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
                            if ($counter === $rowCount) {
                                $last = true;
                            }
                        @endphp
                        <x-table.body-row class="!h-12">
                            <x-table.body-cell>
                                <a href="/schedule/change/{{ $item->id }}/{{ $date->format('Y') . '/' . $date->format('n') }}" class="flex">
                                    <div>
                                        <x-profilePic :path="$item->profilePic" class="w-[30px] h-[30px]" />
                                    </div>
                                    <div class="px-2 flex items-center">
                                        {{ $item->firstName }} {{ $item->lastName }}
                                    </div>
                                </a>
                            </x-table.body-cell>
                            @for ($i = 1; $i <= $date->format('t'); $i++)
                                @isset($table[$item->id][$i])
                                    <x-table.body-cell 
                                        class="w-[50px] text-center" 
                                        type="schedule" 
                                        :$loopdate
                                        :$last
                                        color="{{ $table[$item->id][$i]->shift->color }}"
                                        textColor="{{ $table[$item->id][$i]->shift->textColor }}"                                        
                                        ho="{{ $table[$item->id][$i]->flexLoc }}"
                                    >
                                        @php echo str_replace('-', '-<br>', $table[$item->id][$i]->shift->display); @endphp
                                    </x-table.body-cell>
                                @else
                                    <x-table.body-cell class="w-[50px] text-center" :$loopdate :$last />
                                @endisset
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
        </div>
</x-layout>
