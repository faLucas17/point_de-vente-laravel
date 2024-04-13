<?php

use App\Models\User;

test('team professeurs can be removed from teams', function () {
    $this->actingAs($user = User::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    $response = $this->delete('/teams/'.$user->currentTeam->id.'/professeurs/'.$otherUser->id);

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('only team owner can remove team professeurs', function () {
    $user = User::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = User::factory()->create(), ['role' => 'admin']
    );

    $this->actingAs($otherUser);

    $response = $this->delete('/teams/'.$user->currentTeam->id.'/professeurs/'.$user->id);

    $response->assertStatus(403);
});
