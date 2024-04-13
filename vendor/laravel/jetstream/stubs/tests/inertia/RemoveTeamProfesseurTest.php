<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveTeamProfesseurTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_professeurs_can_be_removed_from_teams()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(), ['role' => 'admin']
        );

        $response = $this->delete('/teams/'.$user->currentTeam->id.'/professeurs/'.$otherUser->id);

        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function test_only_team_owner_can_remove_team_professeurs()
    {
        $user = User::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(), ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $response = $this->delete('/teams/'.$user->currentTeam->id.'/professeurs/'.$user->id);

        $response->assertStatus(403);
    }
}
