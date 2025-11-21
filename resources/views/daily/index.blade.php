<x-layout>
    <div class="w-100 overflow-x-auto bg-neutral-700 p-4 mt-4 rounded-md">
        <x-table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell class="w-[200px] md:min-w-1/6">Name</x-table.head-cell>
                    @php
                        $hour = new DateTime('00:00');
                    @endphp
                    @for ($i = 0; $i < 24; $i++)                        
                        <x-table.head-cell class="text-sm w-[50px] text-center">
                            {{ $hour->format('H:i') }} <br>-<br> {{ $hour->modify('+1 hour')->format('H:i') }}
                        </x-table.head-cell>
                    @endfor
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @foreach ($users as $user)
                    <x-table.body-row  class="!h-12">
                            <x-table.body-cell>
                                <div class="flex">
                                    <div>
                                        <x-profilePic :path="$user->profilePic" class="size-[30px]" />
                                    </div>
                                    <div class="px-2 flex items-center">
                                        {{ $user->firstName }} {{ $user->lastName }}
                                    </div>
                                </div>
                            </x-table.body-cell>
                            @php
                                $currentHour = 0;
                                $hasShift = isset($table[$user->id]);
                                $segments = $hasShift ? $table[$user->id]['segments'] : [];
                            @endphp
                            
                            @while ($currentHour < 24)
                                @php
                                    $currentSegment = null;
                                    foreach ($segments as $segment) {
                                        if ($currentHour == $segment['start']) {
                                            $currentSegment = $segment;
                                            break;
                                        }
                                    }
                                @endphp
                                
                                @if ($currentSegment)
                                    {{-- Render shift segment with colspan --}}
                                    @php
                                        $segmentDuration = $currentSegment['end'] - $currentSegment['start'];
                                    @endphp
                                    <x-table.body-cell 
                                        class="text-center" 
                                        style="background-color: {{ $currentSegment['color'] }}; color: {{ $currentSegment['textColor'] }};"
                                        colspan="{{ $segmentDuration }}">
                                        {{ $currentSegment['name'] }}
                                    </x-table.body-cell>
                                    @php
                                        $currentHour = $currentSegment['end'];
                                    @endphp
                                @else
                                    {{-- Render empty cell --}}
                                    <x-table.body-cell class="text-center">
                                        &nbsp;
                                    </x-table.body-cell>
                                    @php
                                        $currentHour++;
                                    @endphp
                                @endif
                            @endwhile
                    </x-table.body-row>
                @endforeach
            </x-table.body>
        </x-table>
    </div>    
</x-layout>