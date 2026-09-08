<?php

it('maps feedback keys to toast copy even when the slot has surrounding whitespace', function (string $key, string $message) {
    $this->blade(<<<BLADE
        <x-modal.feedback>
            {$key}
        </x-modal.feedback>
        BLADE)
        ->assertSee($message)
        ->assertDontSee('No feedback message provided');
})->with([
    'user deleted' => ['userDeleted', 'User deleted successfully'],
    'team deleted' => ['teamDeleted', 'Team deleted successfully'],
    'shift deleted' => ['shiftDeleted', 'Shift deleted successfully'],
    'user created' => ['userCreated', 'User created successfully'],
]);
