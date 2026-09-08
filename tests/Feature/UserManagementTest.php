<?php

use App\Models\Role;
use App\Models\User;

function createAdministrator(): User
{
    $adminRole = Role::create(['name' => 'administrator']);
    Role::create(['name' => 'manager']);
    Role::create(['name' => 'user']);

    return User::factory()->create([
        'role_id' => $adminRole->id,
    ]);
}

it('renders edit and delete as buttons on the user management table', function () {
    $admin = createAdministrator();
    $user = User::factory()->create([
        'role_id' => Role::query()->where('name', 'user')->value('id'),
    ]);

    $response = $this->actingAs($admin)->get('/userManagement');

    $response->assertSuccessful();
    $response->assertSee('type="button"', false);
    $response->assertSee('>Edit</button>', false);
    $response->assertSee('name="_method" value="DELETE"', false);
    $response->assertSee("return confirm('Are you sure you want to delete this?')", false);
    $response->assertSee(route('employee.destroy', $user->id));
    $response->assertSee('>Delete</button>', false);
});

it('deletes a user from the table delete form', function () {
    $admin = createAdministrator();
    $user = User::factory()->create([
        'role_id' => Role::query()->where('name', 'user')->value('id'),
        'validUntil' => null,
    ]);

    $response = $this->actingAs($admin)->delete(route('employee.destroy', $user->id));

    $response->assertRedirect('/userManagement');
    $response->assertSessionHas('feedback', 'userDeleted');
    $user->refresh();

    expect($user->active)->toBe(0)
        ->and($user->deletedBy)->toBe($admin->id)
        ->and($user->deletedAt)->not->toBeNull();

    $this->actingAs($admin)
        ->get('/userManagement')
        ->assertSuccessful()
        ->assertSee('User deleted successfully')
        ->assertDontSee('No feedback message provided');
});
