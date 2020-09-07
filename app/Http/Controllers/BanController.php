<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Ban;
use App\User;
use App\Events\UserBannedEvent;
use App\Http\Requests\BanUserRequest;

class BanController extends Controller
{

    public function insert(BanUserRequest $request, User $user)
    {

        $this->authorize('create', [Ban::class, $user]);

        if (is_null($user->bans))
        {

            $reason = $request->reason;
            $duration = strtolower($request->durationOperator);
            $durationOperand = $request->durationOperand;

            $expiryDate = now();

            if (!empty($duration))
            {
                switch($duration)
                {
                    case 'days':
                        $expiryDate->addDays($durationOperand);
                        break;

                    case 'weeks':
                        $expiryDate->addWeeks($durationOperand);
                        break;

                    case 'months':
                        $expiryDate->addMonths($durationOperand);
                        break;

                    case 'years':
                        $expiryDate->addYears($durationOperand);
                        break;
                }
            }
            else
            {
                // Essentially permanent
                $expiryDate->addYears(100);
            }

            $ban = Ban::create([
                'userID' => $user->id,
                'reason' => $reason,
                'bannedUntil' => $expiryDate,
                'userAgent' => "Unknown",
                'authorUserID' => Auth::user()->id
            ]);

            event(new UserBannedEvent($user, $ban));
            $request->session()->flash('success', 'User banned successfully! Ban ID:  #' . $ban->id);

        }
        else
        {
            $request->session()->flash('error', 'User already banned!');
        }

        return redirect()->back();
    }


    public function delete(Request $request, User $user)
    {

        $this->authorize('delete', $user->bans);

        if (!is_null($user->bans))
        {
            $user->bans->delete();
            $request->session()->flash('success', 'User unbanned successfully!');
        }
        else
        {
            $request->session()->flash('error', 'This user isn\'t banned!');
        }

        return redirect()->back();
    }
}
