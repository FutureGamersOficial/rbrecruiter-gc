<?php


namespace App\Services;


use App\Exceptions\InvalidInviteException;
use App\Exceptions\PublicTeamInviteException;
use App\Exceptions\UserAlreadyInvitedException;
use App\Mail\InviteToTeam;
use App\Team;
use App\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

class TeamService
{

    /**
     * Create a team
     *
     * @param $teamName
     * @param $ownerID
     * @return Team
     */
    public function createTeam($teamName, $ownerID): Team {

        $team = Team::create([
            'name' => $teamName,
            'owner_id' => $ownerID,
        ]);

        Auth::user()->teams()->attach($team->id);

        return $team;
    }

    public function updateTeam(Team $team, $teamDescription, $joinType): bool
    {

        $team->description = $teamDescription;
        $team->openJoin = $joinType;

        return $team->save();
    }

    /**
     * Invites a user to a $team.
     *
     * @throws PublicTeamInviteException Thrown when trying to invite a user to a public team
     * @throws UserAlreadyInvitedException Thrown when a user is already invited
     */
    public function inviteUser(Team $team, $userID): bool
    {

        $user = User::findOrFail($userID);

        if (! $team->openJoin) {
            if (! Teamwork::hasPendingInvite($user->email, $team)) {
                Teamwork::inviteToTeam($user, $team, function (TeamInvite $invite) use ($user) {
                    Mail::to($user)->send(new InviteToTeam($invite));
                });
                return true;
            } else {
                throw new UserAlreadyInvitedException('This user has already been invited.');
            }
        } else {
            throw new PublicTeamInviteException('You can\'t invite users to public teams.');
        }

    }

    /**
     * Accepts or denies a user invite
     *
     * @param Authenticatable $user
     * @param $action
     * @param $token
     * @return bool True on success or exception on failure
     * @throws InvalidInviteException Thrown when the invite code / url is invalid
     */
    public function processInvite(Authenticatable $user, $action, $token): bool {

        switch ($action) {
            case 'accept':

                $invite = Teamwork::getInviteFromAcceptToken($token);

                if ($invite && $invite->user->is($user)) {
                    Teamwork::acceptInvite($invite);

                } else {

                    throw new InvalidInviteException('Invalid or expired invite URL.');
                }

                break;

            case 'deny':

                $invite = Teamwork::getInviteFromDenyToken($token);

                if ($invite && $invite->user->is($user)) {

                    Teamwork::denyInvite($invite);

                } else {

                    throw new InvalidInviteException('Invalid or expired invite URL.');
                }

                break;

            default:
                throw new InvalidInviteException('Sorry, but the invite URL you followed was malformed.');
        }

        return true;

    }


    /**
     * @param Team $team
     * @param $associatedVacancies
     * @return string The success message, exception/bool if error
     */
    public function updateVacancies(Team $team, $associatedVacancies): string
    {

        // P.S. To future developers
        // This method gave me a lot of trouble lol. It's hard to write code when you're half asleep.
        // There may be an n+1 query in the view and I don't think there's a way to avoid that without writing a lot of extra code.

        $requestVacancies = $associatedVacancies;
        $currentVacancies = $team->vacancies->pluck('id')->all();

        if (is_null($requestVacancies)) {
            foreach ($team->vacancies as $vacancy) {
                $team->vacancies()->detach($vacancy->id);
            }

            return 'Removed all vacancy associations.';
        }

        $vacancyDiff = array_diff($requestVacancies, $currentVacancies);
        $deselectedDiff = array_diff($currentVacancies, $requestVacancies);

        if (! empty($vacancyDiff) || ! empty($deselectedDiff)) {
            foreach ($vacancyDiff as $selectedVacancy) {
                $team->vacancies()->attach($selectedVacancy);
            }

            foreach ($deselectedDiff as $deselectedVacancy) {
                $team->vacancies()->detach($deselectedVacancy);
            }
        } else {
            $team->vacancies()->attach($requestVacancies);
        }
        return 'Assignments changed successfully.';
    }
}
