<x-layout>
    <div class="flex justify-end">
        <x-button onclick="openModal('createTeamModal')">+ Add New Team</x-button>
    </div>
    <div class="w-100 overflow-x-auto mt-4 p-4 bg-neutral-700 rounded-md">
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell class="w-[200px] md:w-auto text-start">Name</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto text-start">Manager</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Members</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Actions</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @php
                    $i = 1;
                @endphp
                @foreach ($teams as $team)            
                    <x-table.body-row>
                        <td class="px-3 text-start border-t border-white/30">
                            <p>
                                {{ $team->displayName }}
                            </p>
                            <p class="text-sm text-gray-400">
                                {{ $team->name }}
                            </p>
                        </td>
                        <td class="text-center border-t border-white/30">
                            @foreach($team->manager as $manager)
                                {{ $manager->firstName }} {{ $manager->lastName }}
                            @endforeach
                        </td>
                        <td class="text-center border-t border-white/30">
                            {{ $team->user->count() }}
                        </td>
                        <x-table.options :item=$team category="team" modal="editTeam{{ $i }}"/>
                    </x-table.body-row>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </x-table.body>
        </x-table.table>
    </div>

    <form action="{{ route('teams.store') }}" method="POST">
        @csrf
        <x-form.teamModal modalName="createTeamModal">
            <x-slot:heading>Add Team</x-slot:heading>
        </x-form.teamModal>
    </form>

    @php
        $i = 1;
    @endphp
    @foreach ($teams as $item)
        <form action="{{ route('teams.update', $item->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <x-form.teamModal modalName="editTeam{{ $i }}" :team="$item">
                <x-slot:heading>Edit Team {{ $item->displayName }}</x-slot:heading>
            </x-form.teamModal>
            @php
                $i++;
            @endphp
        </form>
    @endforeach
    
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
</x-layout>