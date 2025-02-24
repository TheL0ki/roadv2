<x-layout>
    <div class="space-y-4 pt-4">
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell class="w-1/6">Name</x-table.head-cell>
                    <x-table.head-cell class="w-1/6">Display</x-table.head-cell>
                    <x-table.head-cell class="w-1/6">Colors</x-table.head-cell>
                    <x-table.head-cell class="w-1/6">Hours</x-table.head-cell>
                    <x-table.head-cell class="w-1/6">Flexible Location</x-table.head-cell>
                    <x-table.head-cell class="w-1/6">Options</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @php
                    $i = 1;
                @endphp
                @foreach ($shifts as $shift)
                    <x-table.body-row>
                        <x-table.body-cell class="text-center">{{ $shift->name }}</x-table.body-cell>
                        <x-table.body-cell class="text-center">{{ $shift->display }}</x-table.body-cell>
                        <x-table.body-cell>
                            <div style="background-color: {{ $shift->color }}; color: {{ $shift->textColor }};">
                                Background: {{ strtoupper($shift->color) }}<br>
                                Text: {{ strtoupper($shift->textColor) }}
                            </div>
                        </x-table.body-cell>
                        <x-table.body-cell class="text-center">{{ $shift->hours }}</x-table.body-cell>
                        <x-table.body-cell class="text-center">{{ $shift->flexLoc }}</x-table.body-cell>
                        <x-table.options :item=$shift category="shift" modal="editShift{{ $i }}" />
                    </x-table.body-row>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </x-table.body>
        </x-table.table>
    </div>

    <x-modal.feedback>
        {{ session('feedback') }}
    </x-modal.feedback>

    @if (session('feedback'))
        <script>
            document.getElementById("feedbackModal").classList.remove('hidden');

            setTimeout(() => {
                document.getElementById("feedbackModal").classList.add('hidden');
            }, 2000);
        </script>
    @endif

    <div class="pt-4">
        <x-button onclick="openModal('createShiftModal')">Add Shift</x-button>
    </div>

    <form action="{{ route('shift.store') }}" method="POST">
        @csrf
        <x-form.shiftModal modalName="createShiftModal">
            <x-slot:heading>Add Shift</x-slot:heading>
        </x-form.shiftModal>
    </form>

    @php
        $i = 1;
    @endphp
    @foreach ($shifts as $item)
        <form action="{{ route('shift.update', $item->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <x-form.shiftModal modalName="editShift{{ $i }}" :shift="$item">
                <x-slot:heading>Edit User {{ $item->display }}</x-slot:heading>
            </x-form.shiftModal>
            @php
                $i++;
            @endphp
        </form>
    @endforeach
</x-layout>