<?php

use App\Models\User;
use Laravel\Jetstream\Http\Livewire\TeamProfesseurManager;
use Livewire\Livewire;

test('team professeurs can be removed from teams', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    $component = Livewire::test(TeamProfesseurManager::class, ['team' => $user->currentTeam])
                    ->set('teamProfesseurIdBeingRemoved', $otherUser->id)
                    ->call('removeTeamProfesseur');

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('only team owner can remove team professeurs', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    $this->actingAs($otherUser);

    $component = Livewire::test(TeamProfesseurManager::class, ['team' => $user->currentTeam])
                    ->set('teamProfesseurIdBeingRemoved', $user->id)
                    ->call('removeTeamProfesseur')
                    ->assertStatus(403);
});
