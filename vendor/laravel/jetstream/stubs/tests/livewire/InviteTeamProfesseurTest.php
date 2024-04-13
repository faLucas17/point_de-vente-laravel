<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\TeamProfesseurManager;
use Laravel\Jetstream\Mail\TeamInvitation;
use Livewire\Livewire;
use Tests\TestCase;

class InviteTeamProfesseurTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_professeurs_can_be_invited_to_team()
    {
        if (! Features::sendsTeamInvitations()) {
            return $this->markTestSkipped('Team invitations not enabled.');
        }

        Mail::fake();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $component = Livewire::test(TeamProfesseurManager::class, ['team' => $user->currentTeam])
                        ->set('addTeamProfesseurForm', [
                            'email' => 'test@example.com',
                            'role' => 'admin',
                        ])->call('addTeamProfesseur');

        Mail::assertSent(TeamInvitation::class);

        $this->assertCount(1, $user->currentTeam->fresh()->teamInvitations);
    }

    public function test_team_professeur_invitations_can_be_cancelled()
    {
        if (! Features::sendsTeamInvitations()) {
            return $this->markTestSkipped('Team invitations not enabled.');
        }

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

        $this->assertCount(0, $user->currentTeam->fresh()->teamInvitations);
    }
}
