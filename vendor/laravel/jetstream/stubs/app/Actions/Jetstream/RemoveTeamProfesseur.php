<?php

namespace App\Actions\Jetstream;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\RemovesTeamProfesseurs;
use Laravel\Jetstream\Events\TeamProfesseurRemoved;

class RemoveTeamProfesseur implements RemovesTeamProfesseurs
{
    /**
     * Remove the team professeur from the given team.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  mixed  $teamProfesseur
     * @return void
     */
    public function remove($user, $team, $teamProfesseur)
    {
        $this->authorize($user, $team, $teamProfesseur);

        $this->ensureUserDoesNotOwnTeam($teamProfesseur, $team);

        $team->removeUser($teamProfesseur);

        TeamProfesseurRemoved::dispatch($team, $teamProfesseur);
    }

    /**
     * Authorize that the user can remove the team professeur.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  mixed  $teamProfesseur
     * @return void
     */
    protected function authorize($user, $team, $teamProfesseur)
    {
        if (! Gate::forUser($user)->check('removeTeamProfesseur', $team) &&
            $user->id !== $teamProfesseur->id) {
            throw new AuthorizationException;
        }
    }

    /**
     * Ensure that the currently authenticated user does not own the team.
     *
     * @param  mixed  $teamProfesseur
     * @param  mixed  $team
     * @return void
     */
    protected function ensureUserDoesNotOwnTeam($teamProfesseur, $team)
    {
        if ($teamProfesseur->id === $team->owner->id) {
            throw ValidationException::withMessages([
                'team' => [__('You may not leave a team that you created.')],
            ])->errorBag('removeTeamProfesseur');
        }
    }
}
