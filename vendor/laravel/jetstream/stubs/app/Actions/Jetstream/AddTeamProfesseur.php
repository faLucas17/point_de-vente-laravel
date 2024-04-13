<?php

namespace App\Actions\Jetstream;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\AddsTeamProfesseurs;
use Laravel\Jetstream\Events\AddingTeamProfesseur;
use Laravel\Jetstream\Events\TeamProfesseurAdded;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Rules\Role;

class AddTeamProfesseur implements AddsTeamProfesseurs
{
    /**
     * Add a new team professeur to the given team.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  string  $email
     * @param  string|null  $role
     * @return void
     */
    public function add($user, $team, string $email, string $role = null)
    {
        Gate::forUser($user)->authorize('addTeamProfesseur', $team);

        $this->validate($team, $email, $role);

        $newTeamProfesseur = Jetstream::findUserByEmailOrFail($email);

        AddingTeamProfesseur::dispatch($team, $newTeamProfesseur);

        $team->users()->attach(
            $newTeamProfesseur, ['role' => $role]
        );

        TeamProfesseurAdded::dispatch($team, $newTeamProfesseur);
    }

    /**
     * Validate the add professeur operation.
     *
     * @param  mixed  $team
     * @param  string  $email
     * @param  string|null  $role
     * @return void
     */
    protected function validate($team, string $email, ?string $role)
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules(), [
            'email.exists' => __('We were unable to find a registered user with this email address.'),
        ])->after(
            $this->ensureUserIsNotAlreadyOnTeam($team, $email)
        )->validateWithBag('addTeamProfesseur');
    }

    /**
     * Get the validation rules for adding a team professeur.
     *
     * @return array
     */
    protected function rules()
    {
        return array_filter([
            'email' => ['required', 'email', 'exists:users'],
            'role' => Jetstream::hasRoles()
                            ? ['required', 'string', new Role]
                            : null,
        ]);
    }

    /**
     * Ensure that the user is not already on the team.
     *
     * @param  mixed  $team
     * @param  string  $email
     * @return \Closure
     */
    protected function ensureUserIsNotAlreadyOnTeam($team, string $email)
    {
        return function ($validator) use ($team, $email) {
            $validator->errors()->addIf(
                $team->hasUserWithEmail($email),
                'email',
                __('This user already belongs to the team.')
            );
        };
    }
}
