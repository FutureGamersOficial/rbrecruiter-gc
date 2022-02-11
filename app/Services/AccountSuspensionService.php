<?php declare(strict_types=1);


namespace App\Services;

use App\Ban;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountSuspensionService
{

    /**
     * Suspends a user account, with given $reason.
     *
     * This method will take the target user and add a suspension to the database,
     * effectively banning the user from the app. Suspensions may be temporary or permanent.
     * Suspensions also block registration attempts.
     *
     * @param string $reason Suspension reason.
     * @param string $duration Duration. This is a timestamp.
     * @param User $target Who to suspend.
     * @param string $type Permanent or temporary?
     * @return Ban The ban itself
     */
    public function suspend($reason, $duration, User $target, $type = "on"): Ban {

        Log::alert("An user account has just been suspended.", [
            'taget_email' => $target->email,
            'suspended_by' => Auth::user()->email,
            'reason' => $reason
        ]);

        if ($type == "on") {
            $expiryDate = now()->addDays($duration);
        }

        $ban = Ban::create([
            'userID' => $target->id,
            'reason' => $reason,
            'bannedUntil' => ($type == "on") ? $expiryDate->format('Y-m-d H:i:s') : null,
            'authorUserID' => Auth::user()->id,
            'isPermanent' => ($type == "off") ? true : false
        ]);

        return $ban;
    }

    /**
     * Lifts someone's suspension
     *
     * @param User $user The user to unsuspend
     */
    public function unsuspend(User $user): void {

        Log::alert("A suspension has just been lifted.", [
            'target_email' => $user->email,
        ]);

        $user->bans->delete();
    }

    /**
     * Checks whether a user is suspended
     *
     * @param User $user The user to check
     * @return bool Whether the mentioned user is suspended
     */
    public function isSuspended(User $user): bool {
        return !is_null($user->bans);
    }


    /**
     * Takes a suspension directly and makes it permanent.
     *
     * @param Ban $ban The suspension to make permanent
     */
    public function makePermanent(Ban $ban): void {

        Log::alert('A suspension has just been made permanent.', [
            'target_email' => $ban->user->email
        ]);

        $ban->bannedUntil = null;
        $ban->isPermanent = true;

        $ban->save();

    }

    /**
     * Purges old, expired suspensions from the database
     *
     * @return bool Whether any suspensions were lifted
     */
    public function purgeExpired()
    {
        // Unban on the last day, not on the exact time (with Carbon::now()).
        return (bool) Ban::whereDate('bannedUntil', '=', Carbon::today())->delete();
    }


}
