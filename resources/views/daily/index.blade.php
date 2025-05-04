<x-layout>
    <div class="w-100 overflow-x-auto">
        <x-table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell class="w-[200px] md:min-w-1/6">Name</x-table.head-cell>
                    @php
                        $hour = new DateTime('00:00');
                    @endphp
                    @for ($i = 0; $i < 24; $i++)                        
                        <x-table.head-cell class="text-sm w-[50px] text-center">
                            {{ $hour->format('H:i') }} - {{ $hour->modify('+1 hour')->format('H:i') }}
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
                            @for ($i = 0; $i < 24; $i++)
                                <x-table.body-cell></x-table.body-cell>
                            @endfor
                    </x-table.body-row>
                @endforeach
            </x-table.body>
        </x-table>
    </div>    
</x-layout>