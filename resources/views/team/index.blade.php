<x-layout>
    <div class="w-100 overflow-x-auto">
        <x-table.table>
            <x-table.head>
                <x-table.head-row>
                    <x-table.head-cell class="w-[200px] md:w-auto">Name</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Display Name</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Manager</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Members</x-table.head-cell>
                    <x-table.head-cell class="w-[200px] md:w-auto">Options</x-table.head-cell>
                </x-table.head-row>
            </x-table.head>
            <x-table.body>
                @php
                    $i = 1;
                @endphp
                @foreach ($teams as $team)            
                    <x-table.body-row>
                        <x-table.body-cell class="text-center">{{ $team->name }}</x-table.body-cell>
                        <x-table.body-cell class="text-center">{{ $team->displayName }}</x-table.body-cell>
                        <x-table.body-cell class="text-center">
                            @foreach($team->manager as $manager)
                                {{ $manager->firstName }} {{ $manager->lastName }}
                            @endforeach
                        </x-table.body-cell>
                        <x-table.body-cell class="text-center">
                            {{ $team->user->count() }}
                        </x-table.body-cell>
                        <x-table.options :item=$team category="team" modal="editTeam{{ $i }}"/>
                    </x-table.body-row>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </x-table.body>
        </x-table.table>
    </div>
    
    <div class="pt-4">
        <x-button onclick="openModal('createTeamModal')">Add New Team</x-button>
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