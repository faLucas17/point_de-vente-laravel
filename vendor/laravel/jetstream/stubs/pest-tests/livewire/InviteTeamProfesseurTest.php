<?php

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\TeamProfesseurManager;
use Laravel\Jetstream\Mail\TeamInvitation;
use Livewire\Livewire;

test('team professeurs can be invited to team', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $component = Livewire::test(TeamProfesseurManager::class, ['team' => $user->currentTeam])
                    ->set('addTeamProfesseurForm', [
                        'email' => 'test@example.com',
                        'role' => 'admin',
                    ])->call('addTeamProfesseur');

    Mail::assertSent(TeamInvitation::class);

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(1);
})->skip(function () {
    return ! Features::sendsTeamInvitations();
}, 'Team invitations not enabled.');

test('team professeur invitations can be cancelled', function () {
    Mail::fake();

    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    // Add the team professeur...
    $component = Livewire::test(TeamProfesseurManager::class, ['team' => $user->currentTeam])
                    ->set('addTeamProfesseurForm', [
                        'email' => 'test@example.com',
                        'role' => 'admin',
                    ])->call('addTeamProfesseur');

    $invitationId = $user->currentTeam->fresh()->teamInvitations->first()->id;

    // Cancel the team invitation...
    $component->call('cancelTeamInvitation', $invitationId);

    expect($user->currentTeam->fresh()->teamInvitations)->toHaveCount(0);
})->skip(function () {
    return ! Features::sendsTeamInvitations();
}, 'Team invitations not enabled.');
