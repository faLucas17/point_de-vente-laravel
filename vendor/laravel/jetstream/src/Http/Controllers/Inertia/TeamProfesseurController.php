<?php

namespace Laravel\Jetstream\Http\Controllers\Inertia;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Jetstream\Actions\UpdateTeamProfesseurRole;
use Laravel\Jetstream\Contracts\AddsTeamProfesseurs;
use Laravel\Jetstream\Contracts\InvitesTeamProfesseurs;
use Laravel\Jetstream\Contracts\RemovesTeamProfesseurs;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;

class TeamProfesseurController extends Controller
{
    /**
     * Add a new team professeur to a team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        if (Features::sendsTeamInvitations()) {
            app(InvitesTeamProfesseurs::class)->invite(
                $request->user(),
                $team,
                $request->email ?: '',
                $request->role
            );
        } else {
            app(AddsTeamProfesseurs::class)->add(
                $request->user(),
                $team,
                $request->email ?: '',
                $request->role
            );
        }

        return back(303);
    }

    /**
     * Update the given team professeur's role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $teamId, $userId)
    {
        app(UpdateTeamProfesseurRole::class)->update(
            $request->user(),
            Jetstream::newTeamModel()->findOrFail($teamId),
            $userId,
            $request->role
        );

        return back(303);
    }

    /**
     * Remove the given user from the given team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $teamId
     * @param  int  $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $teamId, $userId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        app(RemovesTeamProfesseurs::class)->remove(
            $request->user(),
            $team,
            $user = Jetstream::findUserByIdOrFail($userId)
        );

        if ($request->user()->id === $user->id) {
            return redirect(config('fortify.home'));
        }

        return back(303);
    }
}
