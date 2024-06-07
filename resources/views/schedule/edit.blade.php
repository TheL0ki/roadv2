<x-layout>
    <form action="/schedule/{{ $user->id }}/update" method="POST">
        @csrf
        @method('PATCH')
        <div class="space-y-2">
            <x-table.table>
                <x-table.body-row class="border border-white/20">
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
                    @for ($i = 1; $i <= 15; $i++)
                        <x-table.head-cell>
                            {{ $i }}
                        </x-table.head-cell>
                    @endfor
                </x-table.body-row>
                <x-table.body-row>
                    @for ($i = 1; $i <= 15; $i++)
                        <x-table.body-cell class="text-center">
                            <x-form.select>
                                @foreach ($user->team->shift as $shift)
                                    <option>{{ $shift->display }}</option>
                                @endforeach
                            </x-form.select>
                        </x-table.body-cell>
                    @endfor
                </x-table.body-row>
                <x-table.body-row>
                    @for ($i = 16; $i <= 30; $i++)
                        <x-table.head-cell>
                            {{ $i }}
                        </x-table.head-cell>
                    @endfor
                </x-table.body-row>
                <x-table.body-row>
                    @for ($i = 16; $i <= 30; $i++)
                        <x-table.body-cell class="text-center">
                            <x-form.select>
                                @foreach ($user->team->shift as $shift)
                                    <option>{{ $shift->display }}</option>
                                @endforeach
                            </x-form.select>
                        </x-table.body-cell>                        
                    @endfor
                </x-table.body-row>
            </x-table.table>
            <x-button>Save</x-button>
        </div>
    </form>
</x-layout>