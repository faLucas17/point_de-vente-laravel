<?php

namespace Laravel\Jetstream\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Actions\UpdateTeamProfesseurRole;
use Laravel\Jetstream\Contracts\AddsTeamProfesseurs;
use Laravel\Jetstream\Contracts\InvitesTeamProfesseurs;
use Laravel\Jetstream\Contracts\RemovesTeamProfesseurs;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Role;
use Livewire\Component;

class TeamProfesseurManager extends Component
{
    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * Indicates if a user's role is currently being managed.
     *
     * @var bool
     */
    public $currentlyManagingRole = false;

    /**
     * The user that is having their role managed.
     *
     * @var mixed
     */
    public $managingRoleFor;

    /**
     * The current role for the user that is having their role managed.
     *
     * @var string
     */
    public $currentRole;

    /**
     * Indicates if the application is confirming if a user wishes to leave the current team.
     *
     * @var bool
     */
    public $confirmingLeavingTeam = false;

    /**
     * Indicates if the application is confirming if a team professeur should be removed.
     *
     * @var bool
     */
    public $confirmingTeamProfesseurRemoval = false;

    /**
     * The ID of the team professeur being removed.
     *
     * @var int|null
     */
    public $teamProfesseurIdBeingRemoved = null;

    /**
     * The "add team professeur" form state.
     *
     * @var array
     */
    public $addTeamProfesseurForm = [
        'email' => '',
        'role' => null,
    ];

    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team)
    {
        $this->team = $team;
    }

    /**
     * Add a new team professeur to a team.
     *
     * @return void
     */
    public function addTeamProfesseur()
    {
        $this->resetErrorBag();

        if (Features::sendsTeamInvitations()) {
            app(InvitesTeamProfesseurs::class)->invite(
                $this->user,
                $this->team,
                $this->addTeamProfesseurForm['email'],
                $this->addTeamProfesseurForm['role']
            );
        } else {
            app(AddsTeamProfesseurs::class)->add(
                $this->user,
                $this->team,
                $this->addTeamProfesseurForm['email'],
                $this->addTeamProfesseurForm['role']
            );
        }

        $this->addTeamProfesseurForm = [
            'email' => '',
            'role' => null,
        ];

        $this->team = $this->team->fresh();

        $this->emit('saved');
    }

    /**
     * Cancel a pending team professeur invitation.
     *
     * @param  int  $invitationId
     * @return void
     */
    public function cancelTeamInvitation($invitationId)
    {
        if (! empty($invitationId)) {
            $model = Jetstream::teamInvitationModel();

            $model::whereKey($invitationId)->delete();
        }

        $this->team = $this->team->fresh();
    }

    /**
     * Allow the given user's role to be managed.
     *
     * @param  int  $userId
     * @return void
     */
    public function manageRole($userId)
    {
        $this->currentlyManagingRole = true;
        $this->managingRoleFor = Jetstream::findUserByIdOrFail($userId);
        $this->currentRole = $this->managingRoleFor->teamRole($this->team)->key;
    }

    /**
     * Save the role for the user being managed.
     *
     * @param  \Laravel\Jetstream\Actions\UpdateTeamProfesseurRole  $updater
     * @return void
     */
    public function updateRole(UpdateTeamProfesseurRole $updater)
    {
        $updater->update(
            $this->user,
            $this->team,
            $this->managingRoleFor->id,
            $this->currentRole
        );

        $this->team = $this->team->fresh();

        $this->stopManagingRole();
    }

    /**
     * Stop managing the role of a given user.
     *
     * @return void
     */
    public function stopManagingRole()
    {
        $this->currentlyManagingRole = false;
    }

    /**
     * Remove the currently authenticated user from the team.
     *
     * @param  \Laravel\Jetstream\Contracts\RemovesTeamProfesseurs  $remover
     * @return void
     */
    public function leaveTeam(RemovesTeamProfesseurs $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            $this->user
        );

        $this->confirmingLeavingTeam = false;

        $this->team = $this->team->fresh();

        return redirect(config('fortify.home'));
    }

    /**
     * Confirm that the given team professeur should be removed.
     *
     * @param  int  $userId
     * @return void
     */
    public function confirmTeamProfesseurRemoval($userId)
    {
        $this->confirmingTeamProfesseurRemoval = true;

        $this->teamProfesseurIdBeingRemoved = $userId;
    }

    /**
     * Remove a team professeur from the team.
     *
     * @param  \Laravel\Jetstream\Contracts\RemovesTeamProfesseurs  $remover
     * @return void
     */
    public function removeTeamProfesseur(RemovesTeamProfesseurs $remover)
    {
        $remover->remove(
            $this->user,
            $this->team,
            $user = Jetstream::findUserByIdOrFail($this->teamProfesseurIdBeingRemoved)
        );

        $this->confirmingTeamProfesseurRemoval = false;

        $this->teamProfesseurIdBeingRemoved = null;

        $this->team = $this->team->fresh();
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Get the available team professeur roles.
     *
     * @return array
     */
    public function getRolesProperty()
    {
        return collect(Jetstream::$roles)->transform(function ($role) {
            return with($role->jsonSerialize(), function ($data) {
                return (new Role(
                    $data['key'],
                    $data['name'],
                    $data['permissions']
                ))->description($data['description']);
            });
        })->values()->all();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('teams.team-professeur-manager');
    }
}
