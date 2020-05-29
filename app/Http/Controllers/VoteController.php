<?php

namespace App\Http\Controllers;

use App\Application;
use App\Http\Requests\VoteRequest;
use App\Jobs\ProcessVoteList;
use App\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VoteController extends Controller
{

    public function vote(VoteRequest $voteRequest, $applicationID)
    {
        $application = Application::find($applicationID);

        if (!is_null($application))
        {
            $vote = Vote::create([
                'userID' => Auth::user()->id,
                'allowedVoteType' => $voteRequest->voteType,
            ]);

            $vote->application()->attach($applicationID);

            Log::info('User ' . Auth::user()->name . ' has voted in applicant ' . $application->user->name . '\'s application', [
                'voteType' => $voteRequest->voteType
            ]);

            $voteRequest->session()->flash('success', 'Your vote has been registered! You will now be notified about the outcome of this application.');
        }
        else
        {
            $voteRequest->session()->flash('error', 'Can\t vote a non existant application!');
        }

        // Cron job will run command that processes votes

        return redirect()->back();
    }
}
