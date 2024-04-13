<?php

use App\Models\User;

test('team professeur roles can be updated', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    $response = $this->put('/teams/'.$user->currentTeam->id.'/professeurs/'.$otherUser->id, [
        'role' => 'editor',
    ]);

    expect($otherUser->fresh()->hasTeamRole(
        $user->currentTeam->fresh(), 'editor'
    ))->toBeTrue();
});

test('only team owner can update team professeur roles', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    $this->actingAs($otherUser);

    $response = $this->put('/teams/'.$user->currentTeam->id.'/professeurs/'.$otherUser->id, [
        'role' => 'editor',
    ]);

    expect($otherUser->fresh()->hasTeamRole(
        $user->currentTeam->fresh(), 'admin'
    ))->toBeTrue();
});
