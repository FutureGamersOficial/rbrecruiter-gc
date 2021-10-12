<?php declare(strict_types=1);


namespace App\Services;

use App\Ban;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountSuspensionService
{

    public function suspend($reason, $duration, User $target, $type = "on"): Ban {

        Log::debug("AccountSuspensionService: Suspending user account", [
            'userID' => $target->id
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

    public function unsuspend(User $user): void {
        $user->bans->delete();
    }

    public function isSuspended(User $user): bool {
        return !is_null($user->bans);
    }

    public function makePermanent(Ban $ban): void {

        $ban->bannedUntil = null;
        $ban->isPermanent = true;

        $ban->save();

    }


}
