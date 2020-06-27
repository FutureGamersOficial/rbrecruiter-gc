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

        if ($user->is(Auth::user()))
        {
            $request->session()->flash('error', 'You can\'t ban yourself!');
            return redirect()->back();
        }

        if (is_null($user->bans))
        {

            $reason = $request->reason;
            $duration = strtolower($request->durationOperator);
            $durationOperand = $request->durationOperand;


            if (!empty($duration))
            {
                $expiryDate = now();

                switch($duration)
                {
                    case 'days':
                        $expiryDate->addDays($duration);
                        break;

                    case 'weeks':
                        $expiryDate->addWeeks($duration);
                        break;

                    case 'months':
                        $expiryDate->addMonths($duration);
                        break;

                    case 'years':
                        $expiryDate->addYears($duration);
                        break;
                }
            }

            $ban = Ban::create([
                'userID' => $user->id,
                'reason' => $request->reason,
                'bannedUntil' => $expiryDate->toDateTimeString() ?? null,
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
