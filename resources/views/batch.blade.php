<x-layout>
    @if($errors->any())
        {{ $errors }}
    @endif
    <div class="max-w-4xl mx-auto pt-4">
        <!-- Wizard Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">📋 Batch Schedule Creation</h1>
            <p class="text-gray-400">Create schedules for multiple users at once</p>
        </div>

        <!-- Progress Steps -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex items-center" data-step="1">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-gray-400 font-semibold text-sm step-circle" data-step="1">1</div>
                    <span class="ml-2 text-gray-400 step-text" data-step="1">Configuration</span>
                </div>
                <div class="w-12 h-0.5 bg-gray-600"></div>
                <div class="flex items-center" data-step="2">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-gray-400 font-semibold text-sm step-circle" data-step="2">2</div>
                    <span class="ml-2 text-gray-400 step-text" data-step="2">Users</span>
                </div>
                <div class="w-12 h-0.5 bg-gray-600"></div>
                <div class="flex items-center" data-step="3">
                    <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-gray-400 font-semibold text-sm step-circle" data-step="3">3</div>
                    <span class="ml-2 text-gray-400 step-text" data-step="3">Review</span>
                </div>
            </div>
        </div>

        <!-- Step 1: Configuration -->
        <div id="step-1" class="wizard-step">
            <div class="bg-neutral-700 rounded-lg p-6 mb-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-white mb-2">Step 1: Schedule Configuration</h2>
                    <p class="text-gray-400">Choose the shift, date range, and weekdays for your batch schedule.</p>
                </div>

                <form id="batchForm" action="{{ route('batch.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    
                    <!-- Date and Shift Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div>
                            <label for="shift" class="block text-sm font-medium text-white mb-2">Shift</label>
                            <x-form.select name="shift" class="w-full">
                                    @foreach ($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->display }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            <div>
                            <label for="month" class="block text-sm font-medium text-white mb-2">Month</label>
                            <x-form.select name="month" class="w-full">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </x-form.select>
                            </div>
                            <div>
                            <label for="year" class="block text-sm font-medium text-white mb-2">Year</label>
                            <x-form.select name="year" class="w-full">
                                    <option value="{{ $date->format('Y')-2}}">{{ $date->format('Y')-2 }}</option>
                                    <option value="{{ $date->format('Y')-1}}">{{ $date->format('Y')-1 }}</option>
                                    <option value="{{ $date->format('Y')}}" selected="selected">{{ $date->format('Y') }}</option>
                                    <option value="{{ $date->format('Y')+1}}">{{ $date->format('Y')+1 }}</option>
                                    <option value="{{ $date->format('Y')+2}}">{{ $date->format('Y')+2 }}</option>
                                </x-form.select>
                            </div>
                        </div>

                    <!-- Weekdays Selection -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-white mb-4">Select Weekdays</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @php
                                $weekdays = [
                                    ['value' => 1, 'name' => 'Monday'],
                                    ['value' => 2, 'name' => 'Tuesday'],
                                    ['value' => 3, 'name' => 'Wednesday'],
                                    ['value' => 4, 'name' => 'Thursday'],
                                    ['value' => 5, 'name' => 'Friday'],
                                    ['value' => 6, 'name' => 'Saturday'],
                                    ['value' => 7, 'name' => 'Sunday']
                                ];
                            @endphp
                            @foreach($weekdays as $day)
                                <label class="flex items-center p-3 bg-neutral-600 rounded-lg hover:bg-neutral-500 cursor-pointer transition-colors">
                                    <input type="checkbox" name="weekday[]" value="{{ $day['value'] }}" 
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-3">
                                    <span class="text-white font-medium">{{ $day['name'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hidden form fields to ensure they're always submitted -->
                    <div style="display: none;">
                                @foreach ($users as $user)
                            <input type="checkbox" name="user[]" value="{{ $user->id }}" class="user-checkbox-hidden">
                                @endforeach
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button type="button" id="next-to-users" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Next: Select Users →
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Step 2: User Selection -->
        <div id="step-2" class="wizard-step hidden">
            <div class="bg-neutral-700 rounded-lg p-6 mb-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-white mb-2">Step 2: Select Users</h2>
                    <p class="text-gray-400">Choose which users will receive this batch schedule.</p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">Available Users</h3>
                        <div class="text-sm text-gray-300">
                            <span id="selectedCount">0</span> of {{ count($users) }} selected
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 max-h-80 overflow-y-auto">
                        @foreach ($users as $user)
                            <label class="relative cursor-pointer">
                                <input type="checkbox" name="user[]" value="{{ $user->id }}" class="sr-only peer user-checkbox">
                                <div class="bg-neutral-600 rounded-lg p-4 border-2 border-transparent peer-checked:border-blue-400 peer-checked:bg-blue-500/20 hover:bg-neutral-500 transition-all duration-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($user->firstName, 0, 1) . substr($user->lastName, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-white truncate">
                                                {{ $user->firstName }} {{ $user->lastName }}
                                            </p>
                                            <p class="text-xs text-gray-300 truncate">
                                                {{ $user->email }}
                                            </p>
                                            @if($user->team)
                                                <p class="text-xs text-blue-300">
                                                    {{ $user->team->displayName }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button type="button" id="back-to-config" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        ← Back to Configuration
                    </button>
                    <button type="button" id="next-to-review" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Next: Review & Confirm →
                    </button>
                </div>
            </div>
        </div>


        <!-- Step 3: Review & Confirm -->
        <div id="step-3" class="wizard-step hidden">
            <div class="bg-neutral-700 rounded-lg p-6 mb-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-white mb-2">Step 3: Review & Confirm</h2>
                    <p class="text-gray-400">Review your batch schedule settings before creating.</p>
                </div>

                <div class="space-y-6">
                    <!-- Configuration Summary -->
                    <div class="bg-neutral-800 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-white mb-4">Schedule Configuration</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-400">Shift:</span>
                                <span id="review-shift" class="text-white ml-2">-</span>
                            </div>
                            <div>
                                <span class="text-gray-400">Date:</span>
                                <span id="review-date" class="text-white ml-2">-</span>
                        </div>
                        <div>
                                <span class="text-gray-400">Weekdays:</span>
                                <span id="review-weekdays" class="text-white ml-2">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Users Summary -->
                    <div class="bg-neutral-800 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-white mb-4">Selected Users</h3>
                        <div id="review-users" class="text-gray-300">
                            No users selected
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    <button type="button" id="back-to-users" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        ← Back to Users
                    </button>
                    <button type="submit" id="create-batch" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        Create Batch Schedule
                    </button>
                </div>
            </div>
        </div>
            </div>

    <!-- Holiday Management Section -->
    <div class="max-w-4xl mx-auto mt-12">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-white mb-2">🎉 Holiday Management</h2>
            <p class="text-gray-400">Create and manage holiday schedules for all users</p>
        </div>

        <!-- Holiday Assignment Form -->
        <div class="bg-neutral-700 rounded-lg p-6 mb-8">
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-white mb-2">Assign Holiday to All Users</h3>
                <p class="text-gray-400">Select a holiday and date to assign it to all active users.</p>
            </div>

            <form action="{{ route('batch.holiday') }}" method="POST">
                @csrf
                @method('POST')
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    @if(count($holidays) > 1)
                        <div>
                            <label for="holidayId" class="block text-sm font-medium text-white mb-2">Holiday</label>
                            <x-form.select name="holidayId" class="w-full">
                                @foreach ($holidays as $holiday)
                                    <option value="{{ $holiday->id }}">{{ $holiday->name }}</option>
                                @endforeach
                            </x-form.select>
                        </div>
                    @endif

                    <div>
                        <label for="day" class="block text-sm font-medium text-white mb-2">Day</label>
                        <x-form.select name="day" class="w-full">
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </x-form.select>
                    </div>

                    <div>
                        <label for="month" class="block text-sm font-medium text-white mb-2">Month</label>
                        <x-form.select name="month" class="w-full">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </x-form.select>
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-medium text-white mb-2">Year</label>
                        <x-form.select name="year" class="w-full">
                            <option value="{{ $date->format('Y')-2}}">{{ $date->format('Y')-2 }}</option>
                            <option value="{{ $date->format('Y')-1}}">{{ $date->format('Y')-1 }}</option>
                            <option value="{{ $date->format('Y')}}" selected="selected">{{ $date->format('Y') }}</option>
                            <option value="{{ $date->format('Y')+1}}">{{ $date->format('Y')+1 }}</option>
                            <option value="{{ $date->format('Y')+2}}">{{ $date->format('Y')+2 }}</option>
                        </x-form.select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Assign Holiday to All Users
                    </x-button>
                </div>

                @if(count($holidays) === 1)
                    <input type="hidden" name="holidayId" value="{{ $holidays[0]->id }}" readonly>
                @endif
            </form>
        </div>

        <!-- Holiday List Management -->
        <div class="bg-neutral-700 rounded-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-white mb-2">Holiday Templates</h3>
                    <p class="text-gray-400">Manage your holiday templates and their appearance.</p>
                </div>
                <button onclick="openModal('createHoliday')" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>New Holiday</span>
                </button>
            </div>

            @if(count($holidays) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @php $i = 1; @endphp
                    @foreach($holidays as $holiday)
                        <div class="bg-neutral-800 rounded-lg p-4 border border-neutral-600 hover:border-neutral-500 transition-colors">
                            
                            <div class="space-y-2">

                                <h4 class="text-lg font-semibold text-white">{{ $holiday->display }}</h4>
                                
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">Background:</span>
                                    <div class="w-6 h-6 rounded border border-gray-600" style="background-color: {{ $holiday->color }};"></div>
                                    <span class="text-sm text-gray-300 font-mono">{{ strtoupper($holiday->color) }}</span>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">Text:</span>
                                    <div class="w-6 h-6 rounded border border-gray-600" style="background-color: {{ $holiday->textColor }};"></div>
                                    <span class="text-sm text-gray-300 font-mono">{{ strtoupper($holiday->textColor) }}</span>
                                </div>
                                
                                <div class="mt-3 p-2 rounded" style="background-color: {{ $holiday->color }}; color: {{ $holiday->textColor }};">
                                    <span class="text-sm font-medium">Preview: {{ $holiday->display }}</span>
                                </div>

                                <div class="flex items-center justify-between mb-3">
                                    <x-table.options :item=$holiday category="holiday" modal="editHoliday{{ $i }}"></x-table.options>
                                </div>
                            </div>
                        </div>
                        @php $i++; @endphp
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-white mb-2">No Holidays Created</h4>
                    <p class="text-gray-400 mb-4">Create your first holiday template to get started.</p>
                    <button onclick="openModal('createHoliday')" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Create First Holiday
                    </button>
                </div>
            @endif
        </div>
    </div>
    <form action="{{ route('holiday.create') }}" method="POST">
        @csrf
        <x-form.holidayModal modalName="createHoliday">
            <x-slot:heading>Add new Holiday</x-slot:heading>
        </x-form.holidayModal>
    </form>
    @php
        $i = 1;
    @endphp
    @foreach ($holidays as $item)
        <form action="{{ route('holiday.update', $item->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <x-form.holidayModal modalName="editHoliday{{ $i }}" :shift="$item">
                <x-slot:heading>Edit Holiday {{ $item->display }}</x-slot:heading>
            </x-form.holidayModal>
            @php
                $i++;
            @endphp
        </form>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wizard step management
            let currentStep = 1;
            const totalSteps = 3;
            
            // Initialize progress indicator
            updateProgressIndicator(1);
            
            // Step navigation functions
            function showStep(step) {
                // Hide all steps
                document.querySelectorAll('.wizard-step').forEach(el => {
                    el.classList.add('hidden');
                });
                
                // Show current step
                document.getElementById(`step-${step}`).classList.remove('hidden');
                
                // Update progress indicator
                updateProgressIndicator(step);
                
                currentStep = step;
            }
            
            function updateProgressIndicator(step) {
                // Check if elements exist
                const circles = document.querySelectorAll('.step-circle');
                const texts = document.querySelectorAll('.step-text');
                
                if (circles.length === 0 || texts.length === 0) {
                    return;
                }
                
                // Reset all steps to inactive
                circles.forEach((circle) => {
                    circle.classList.remove('bg-blue-500', 'text-white');
                    circle.classList.add('bg-gray-600', 'text-gray-400');
                });
                
                texts.forEach((text) => {
                    text.classList.remove('text-white', 'font-medium');
                    text.classList.add('text-gray-400');
                });
                
                // Activate steps up to current step
                for (let i = 1; i <= step; i++) {
                    const circle = document.querySelector(`.step-circle[data-step="${i}"]`);
                    const text = document.querySelector(`.step-text[data-step="${i}"]`);
                    
                    if (circle) {
                        circle.classList.remove('bg-gray-600', 'text-gray-400');
                        circle.classList.add('bg-blue-500', 'text-white');
                    }
                    if (text) {
                        text.classList.remove('text-gray-400');
                        text.classList.add('text-white', 'font-medium');
                    }
                }
            }
            
            // Navigation event listeners
            document.getElementById('next-to-users').addEventListener('click', function() {
                showStep(2);
            });
            
            document.getElementById('back-to-config').addEventListener('click', function() {
                showStep(1);
            });
            
            const nextToReviewBtn = document.getElementById('next-to-review');
            if (nextToReviewBtn) {
                nextToReviewBtn.addEventListener('click', function() {
                    console.log('Next to review button clicked');
                    try {
                        updateReviewStep();
                        showStep(3);
                    } catch (error) {
                        console.error('Error updating review step:', error);
                        alert('Error updating review information. Please try again.');
                    }
                });
            } else {
                console.error('next-to-review button not found');
            }
            
            document.getElementById('back-to-users').addEventListener('click', function() {
                showStep(2);
            });
            
            // User selection counter and sync with hidden checkboxes
            const checkboxes = document.querySelectorAll('.user-checkbox');
            const hiddenCheckboxes = document.querySelectorAll('.user-checkbox-hidden');
            const counter = document.getElementById('selectedCount');
            
            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    updateCounter();
                    syncHiddenCheckboxes();
                });
            });
            
            function updateCounter() {
                const checked = document.querySelectorAll('.user-checkbox:checked').length;
                counter.textContent = checked;
            }
            
            function syncHiddenCheckboxes() {
                checkboxes.forEach((checkbox, index) => {
                    if (hiddenCheckboxes[index]) {
                        hiddenCheckboxes[index].checked = checkbox.checked;
                    }
                });
            }
            
            // Review step update
            function updateReviewStep() {
                // Update shift
                const shiftSelect = document.querySelector('select[name="shift"]');
                if (shiftSelect) {
                    const shiftOption = shiftSelect.options[shiftSelect.selectedIndex];
                    const reviewShift = document.getElementById('review-shift');
                    if (reviewShift) {
                        reviewShift.textContent = shiftOption ? shiftOption.text : 'Not selected';
                    }
                }
                
                // Update date
                const monthSelect = document.querySelector('select[name="month"]');
                const yearSelect = document.querySelector('select[name="year"]');
                const reviewDate = document.getElementById('review-date');
                if (reviewDate && monthSelect && yearSelect) {
                    reviewDate.textContent = `${monthSelect.value}/${yearSelect.value}`;
                }
                
                // Update weekdays
                const selectedWeekdays = Array.from(document.querySelectorAll('input[name="weekday[]"]:checked'))
                    .map(input => {
                        const dayNames = ['', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                        return dayNames[input.value];
                    });
                const reviewWeekdays = document.getElementById('review-weekdays');
                if (reviewWeekdays) {
                    reviewWeekdays.textContent = selectedWeekdays.length > 0 ? selectedWeekdays.join(', ') : 'None selected';
                }
                
                // Update users - only count visible checkboxes (not hidden ones)
                const selectedUsers = Array.from(document.querySelectorAll('input[name="user[]"]:checked'))
                    .filter(input => !input.classList.contains('user-checkbox-hidden'))
                    .map(input => {
                        const label = input.closest('label');
                        const nameEl = label ? label.querySelector('p.text-sm.font-medium') : null;
                        return nameEl ? nameEl.textContent : 'Unknown';
                    });
                
                const usersContainer = document.getElementById('review-users');
                if (usersContainer) {
                    if (selectedUsers.length > 0) {
                        usersContainer.innerHTML = selectedUsers.map(user => 
                            `<div class="flex items-center space-x-2 mb-2">
                                <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                    ${user.split(' ').map(n => n[0]).join('')}
                                </div>
                                <span>${user}</span>
                            </div>`
                        ).join('');
                    } else {
                        usersContainer.textContent = 'No users selected';
                    }
                }
            }
            
            // Form submission
            document.getElementById('create-batch').addEventListener('click', function() {
                // Sync hidden checkboxes before submission
                syncHiddenCheckboxes();
                
                // Validate that at least one user is selected
                const selectedUsers = document.querySelectorAll('.user-checkbox:checked');
                if (selectedUsers.length === 0) {
                    alert('Please select at least one user before creating the batch schedule.');
                    return;
                }
                
                // Validate that at least one weekday is selected
                const selectedWeekdays = document.querySelectorAll('input[name="weekday[]"]:checked');
                if (selectedWeekdays.length === 0) {
                    alert('Please select at least one weekday before creating the batch schedule.');
                    return;
                }
                
                document.getElementById('batchForm').submit();
            });
        });
    </script>
</x-layout>