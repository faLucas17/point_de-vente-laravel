<?php

namespace Laravel\Jetstream\Actions;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Events\TeamProfesseurUpdated;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;

class UpdateTeamProfesseurRole
{
    /**
     * Update the role for the given team professeur.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  int  $teamProfesseurId
     * @param  string  $role
     * @return void
     */
    public function update($user, $team, $teamProfesseurId, string $role)
    {
        Gate::forUser($user)->authorize('updateTeamProfesseur', $team);

        Validator::make([
            'role' => $role,
        ], [
            'role' => ['required', 'string', new Role],
        ])->validate();

        $team->users()->updateExistingPivot($teamProfesseurId, [
            'role' => $role,
        ]);

        TeamProfesseurUpdated::dispatch($team->fresh(), Jetstream::findUserByIdOrFail($teamProfesseurId));
    }
}
