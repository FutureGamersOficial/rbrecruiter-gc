<?php

namespace App\Console\Commands;

use App\Application;
use App\Events\ApplicationApprovedEvent;
use App\Events\ApplicationDeniedEvent;
use Illuminate\Console\Command;

class CountVotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'votes:evaluate {--d|dryrun : Controls whether passing applicants should be promoted (e.g. only show results)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Iterates through eligible applications and determines if they should be approved based on the number of votes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $eligibleApps = Application::where('applicationStatus', 'STAGE_PEERAPPROVAL')->get();
        $pbar = $this->output->createProgressBar($eligibleApps->count());

        if($eligibleApps->isEmpty())
        {
            $this->error('𐄂 There are no applications that need to be processed.');

            return false;
        }

        foreach ($eligibleApps as $application)
        {
            $votes = $application->votes;
            $voteCount = $application->votes->count();

            $positiveVotes = 0;
            $negativeVotes = 0;

            if ($voteCount > 5)
            {
                $this->info('Counting votes for application ID ' . $application->id);
                foreach ($votes as $vote)
                {
                    switch ($vote->allowedVoteType)
                    {
                        case 'VOTE_APPROVE':
                            $positiveVotes++;
                            break;
                        case 'VOTE_DENY':
                            $negativeVotes++;
                            break;
                    }
                }

                $this->info('Total votes for application ID ' . $application->id . ': ' . $voteCount);
                $this->info('Calculating criteria...');
                $negativeVotePercent = floor(($negativeVotes / $voteCount) * 100);
                $positiveVotePercent = floor(($positiveVotes / $voteCount) * 100);

                $pollResult = $positiveVotePercent > $negativeVotePercent;

                $this->table([
                    '% of approval votes',
                    '% of denial votes'
                ], [ // array of arrays, e.g. rows
                    [
                        $positiveVotePercent . "%",
                        $negativeVotePercent . "%"
                    ]
                ]);

                if ($pollResult)
                {
                    $this->info('✓ Dispatched promotion event for applicant ' . $application->user->name);
                    if (!$this->option('dryrun'))
                    {
                        $application->response->vacancy->vacancyCount -= 1;
                        $application->response->vacancy->save();

                        event(new ApplicationApprovedEvent(Application::find($application->id)));
                    }
                    else
                    {
                        $this->warn('Dry run: Event won\'t be dispatched');
                    }

                    $pbar->advance();

                }
                else {

                    if (!$this->option('dryrun'))
                    {
                        event(new ApplicationDeniedEvent(Application::find($application->id)));
                    }
                    else {
                        $this->warn('Dry run: Event won\'t be dispatched');
                    }

                    $pbar->advance();
                    $this->error('𐄂 Applicant ' . $application->user->name . ' does not meet vote criteria (Majority)');
                }
            }
            else
            {
                $this->warn("Application ID" . $application->id . " did not have enough votes for processing (min 5)");
            }

        }

        $pbar->finish();
        return true;
    }
}
