<?php

namespace Laravel\Jetstream\Contracts;

interface RemovesTeamProfesseurs
{
    /**
     * Remove the team professeur from the given team.
     *
     * @param  mixed  $user
     * @param  mixed  $team
     * @param  mixed  $teamProfesseur
     * @return void
     */
    public function remove($user, $team, $teamProfesseur);
}
