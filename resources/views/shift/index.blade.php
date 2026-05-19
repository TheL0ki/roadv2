<x-layout>
    <div class="flex justify-end">
        <x-button onclick="openModal('createShiftModal')">+ Add Shift</x-button>
    </div>
    <div class="w-100 overflow-x-auto mt-4 p-4 bg-neutral-700 rounded-md">
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell class="w-[100px] md:w-auto text-start">Name</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto text-start">Colors</x-table.head-cell>
                    <x-table.head-cell class="w-[100px] md:w-auto">Start</x-table.head-cell>
                    <x-table.head-cell class="w-[100px] md:w-auto">End</x-table.head-cell>
                    <x-table.head-cell class="w-[100px] md:w-auto">Flexible Location</x-table.head-cell>
                    <x-table.head-cell class="w-[100px] md:w-auto">Overrideable</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Options</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @php
                    $i = 1;
                @endphp
                @foreach ($shifts as $shift)
                    <x-table.body-row>
                        <td class="px-3 text-start border-t border-white/30">
                            <p>{{ $shift->display }}</p>
                            <p class="text-sm text-gray-400">{{ $shift->name }}</p>
                        </td>
                        <td class="border-t border-white/30">

                            <div class="px-2 mt-2 mb-2">
                                <div class="grid grid-cols-2 gap-1">
                                    <span class="text-sm text-gray-400">Background:</span>
                                    <div class="flex justify-start">
                                        <div class="w-6 h-6 rounded border border-gray-600" style="background-color: {{ $shift->color }};"></div>
                                        <span class="ml-2 text-sm text-gray-300 font-mono">{{ strtoupper($shift->color) }}</span>
                                    </div>
                                    <span class="text-sm text-gray-400">Text:</span>
                                    <div class="flex justify-start">
                                        <div class="w-6 h-6 rounded border border-gray-600" style="background-color: {{ $shift->textColor }};"></div>
                                        <span class="ml-2 text-sm text-gray-300 font-mono">{{ strtoupper($shift->textColor) }}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-2 p-2 rounded" style="background-color: {{ $shift->color }}; color: {{ $shift->textColor }};">
                                    <span class="text-sm font-medium">Preview: {{ $shift->display }}</span>
                                </div>
                            </div>

                        </td class="border-t border-white/30">
                        <td class="text-center border-t border-white/30" class="text-center">{{ date('H:i', strtotime($shift->hour_start)) }}</td>
                        <td class="text-center border-t border-white/30" class="text-center">{{ date('H:i', strtotime($shift->hour_end)) }}</td>
                        <td class="text-center border-t border-white/30" class="text-center">
                            @if($shift->flexLoc === 1)
                                ✔️
                            @else
                                ❌
                            @endif
                        </td>
                        <td class="text-center border-t border-white/30" class="text-center">
                            @if($shift->override === 1)
                                ✔️
                            @else
                                ❌
                            @endif
                        </td>
                        <x-table.options :item=$shift category="shift" modal="editShift{{ $i }}" />
                    </x-table.body-row>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </x-table.body>
        </x-table.table>
    </div>

    <x-modal.feedback :details="$errors->first()">
        {{ $errors->any() ? 'savingError' : session('feedback') }}
    </x-modal.feedback>

    @if (session('feedback') || $errors->any())
        <script>
            document.getElementById("feedbackModal").classList.remove('hidden');

            setTimeout(() => {
                document.getElementById("feedbackModal").classList.add('hidden');
            }, 2000);
        </script>
    @endif

    <form action="{{ route('shifts.store') }}" method="POST">
        @csrf
        @method('POST')
        <x-form.shiftModal modalName="createShiftModal">
            <x-slot:heading>Add Shift</x-slot:heading>
        </x-form.shiftModal>
    </form>

    @php
        $i = 1;
    @endphp
    @foreach ($shifts as $item)
        <form action="{{ route('shifts.update', $item->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <x-form.shiftModal modalName="editShift{{ $i }}" :shift="$item">
                <x-slot:heading>Edit Shift {{ $item->display }}</x-slot:heading>
            </x-form.shiftModal>
            @php
                $i++;
            @endphp
        </form>
    @endforeach
</x-layout>