@props(['teams', 'roles', 'modalName', 'user' => null])

<div id="{{ $modalName }}" class="fixed hidden inset-0 bg-gray-950 bg-opacity-60 backdrop-blur-sm transition-opacity duration-300 h-screen w-screen px-4">
    <div class="relative top-20 mx-auto shadow-xl rounded-md bg-neutral-700 max-w-md">
        <div class="flex justify-between p-2 border-b border-white/20">
            <div>
                <h2 class="text-2xl font-bold text-left">{{ $heading }}</h2>
            </div>
            <div>
                <button onclick="closeModal('{{ $modalName }}')" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-8 pt-2 text-center">
            <div class="mb-4">
                <div class="mb-2">
                    <div class="flex items-center justify-between">
                        <label for="firstName" class="block text-sm font-medium leading-6">First Name</label>
                    </div>
                    <div class="mt-2">
                        @if ($user != null)
                            <x-form.textInput id="firstName" name="firstName" type="text" required :value="$user->firstName"></x-form.textInput> 
                        @else
                            <x-form.textInput id="firstName" name="firstName" type="text" required></x-form.textInput>
                        @endif
                    </div>
                </div>

                <div class="mb-2">
                    <div class="flex items-center justify-between">
                        <label for="lastName" class="block text-sm font-medium leading-6">Last Name</label>
                    </div>
                    <div class="mt-2">
                        @if ($user != null)
                            <x-form.textInput id="lastName" name="lastName" type="text" required :value="$user->lastName"></x-form.textInput> 
                        @else
                            <x-form.textInput id="lastName" name="lastName" type="text" required></x-form.textInput>
                        @endif
                    </div>
                </div>

                @if ($user === null)
                    <div class="mb-2">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm font-medium leading-6">Password</label>
                        </div>
                        <div class="mt-2">
                            <x-form.textInput id="password" name="password" type="password" autocomplete="current-password" required></x-form.textInput>                            
                        </div>
                    </div>
                @endif
                
                <div class="mb-2">
                    <div class="flex items-center justify-between">
                        <label for="email" class="block text-sm font-medium leading-6">Email</label>
                    </div>
                    <div class="mt-2">
                        @if ($user != null)
                            <x-form.textInput id="email" name="email" type="text" required :value="$user->email"></x-form.textInput> 
                        @else
                            <x-form.textInput id="email" name="email" type="text" required></x-form.textInput>
                        @endif
                    </div>
                </div>

                <div class="mb-2">
                    <div class="flex items-center justify-between">
                        <label for="slackId" class="block text-sm font-medium leading-6">Slack ID</label>
                    </div>
                    <div class="mt-2">
                        @if ($user != null)
                            <x-form.textInput id="slackId" name="slackId" type="text" required :value="$user->slackId"></x-form.textInput> 
                        @else
                            <x-form.textInput id="slackId" name="slackId" type="text" required></x-form.textInput>
                        @endif
                    </div>
                </div>

                <div class="mb-2">
                    <div class="flex items-center justify-between">
                        <label for="team" class="block text-sm font-medium leading-6">Team</label>
                    </div>
                    <div class="mt-2">
                        <x-form.select id="team_id" name="team_id" required>
                            @if ($user != null)
                                <option value="{{ $user->team->id }}">{{ $user->team->displayName }}</option>
                            @endif
                            <option>--</option>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->displayName }}</option>
                            @endforeach
                        </x-form.select>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="flex items-center justify-between">
                        <label for="role" class="block text-sm font-medium leading-6">Role</label>
                    </div>
                    <div class="mt-2">
                        <div class="grid">
                            <x-form.select id="role_id" name="role_id" required>
                                @if ($user != null)
                                    <option value="{{ $user->role->id }}">{{ $user->role->name }}</option>
                                @endif
                                <option>--</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="flex items-center justify-between">
                        <label for="model" class="block text-sm font-medium leading-6">Model</label>
                    </div>
                    <div class="mt-2">
                        <x-form.select id="model" name="model" required>
                            @if ($user != null)
                                <option value="{{ $user->model }}">@php echo $user->model == 'ft' ?  "Full Time" : "Part Time"; @endphp</option>
                            @endif
                            <option>--</option>
                            <option value="ft">Full Time</option>
                            <option value="pt">Part Time</option>
                        </x-form.select>
                    </div>
                </div>
            </div>

            <div class="flex justify-between pt-2">
                <x-button class="bg-green-600 hover:bg-green-900">Save</x-button>
                <x-button class="bg-red-600 hover:bg-red-900" onclick="closeModal('{{ $modalName }}')">Cancel</x-button>
            </div>
        </div>
    </div>
</div>

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
            let modals = document.getElementsById('{{ $modalName }}');
            Array.prototype.slice.call(modals).forEach(i => {
                i.style.display = 'none'
            })
        }
    };
</script>