<x-layout>
    <x-table>
        <x-table.head>
            <x-table.head-row>
                <x-table.head-cell class="md:w-auto">Name</x-table.head-cell>
                <x-table.head-cell class="md:w-auto">Abilities</x-table.head-cell>
                <x-table.head-cell class="md:w-auto">Created At</x-table.head-cell>
                <x-table.head-cell class="md:w-auto">Last Used</x-table.head-cell>
                <x-table.head-cell class="md:w-auto">Expires At</x-table.head-cell>
                <x-table.head-cell class="md:w-auto">Options</x-table.head-cell>
            </x-table.head-row>
        </x-table.head>
        @foreach ($tokens as $token)
            <x-table.body-row>
                <x-table.body-cell class="text-center">{{ $token->name }}</x-table.body-cell>
                <x-table.body-cell class="text-center">@foreach($token->abilities as $ability) {{ $ability }} @endforeach</x-table.body-cell>
                <x-table.body-cell class="text-center">{{ $token->created_at }}</x-table.body-cell>
                <x-table.body-cell class="text-center">{{ $token->last_used_at }}</x-table.body-cell>
                <x-table.body-cell class="text-center">{{ $token->expires_at }}</x-table.body-cell>
                <x-table.body-cell class="text-center">
                    <form action="/apiAccess" method="POST">
                        @csrf 
                        @method('DELETE')
                        <input type="hidden" name="tokenID" value="{{ $token->id }}">
                        <x-button class="bg-red-600 hover:bg-red-900" type="submit">Revoke</x-button>
                    </form>
                </x-table.body-cell>
            </x-table.body-row>
        @endforeach
    </x-table>
    <div class="mt-2">
        <form action="/apiAccess" method="POST">
            @csrf
            @method('POST')
            <label for="tokenName">Token Name:</label>
            <input class="bg-white/10" type="text" name="tokenName" id="tokenName">
            <x-button class="bg-green-600 hover:bg-green-900" type="submit">Create New Token</x-button>
            @error('tokenName')
                <div class="bg-red-300 text-red-600 border border-red-600 rounded p-2 w-64 mt-2 text-center">
                    {{ $message }}
                </div>
            @enderror
        </form>
    </div>
    @if(session('newToken'))    
        <x-modal.apiKeyModal>
            <x-slot:heading>API Key</x-slot:heading>
            <x-slot:plainTextKey>{{ session('newToken') }}</x-slot:plainTextKey>
        </x-modal.apiKeyModal>

        <script>
            window.onload = function() {
                openModal('apiKeyModal');
            };
        </script>
    @endif

    <script type="text/javascript">            
        window.openModal = function(modalId) {
            document.getElementById(modalId).style.display = 'block'
            document.getElementsByTagName('body')[0].classList.add('overflow-y-hidden')
        };

        window.closeModal = function(modalId) {
            document.getElementById(modalId).style.display = 'none'
            document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
        };

        // Close all modals when press ESC
        document.onkeydown = function(event) {
            event = event || window.event;
            if (event.keyCode === 27) {
                document.getElementsByTagName('body')[0].classList.remove('overflow-y-hidden')
                let modals = document.getElementsById('apiKeyModal');
                Array.prototype.slice.call(modals).forEach(i => {
                    i.style.display = 'none'
                })
            }
        };
    </script>
</x-layout>