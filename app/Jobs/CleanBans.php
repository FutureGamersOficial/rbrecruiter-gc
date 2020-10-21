<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Ban;
use Carbon\Carbon;

class CleanBans implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $bans;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Log::debug('Running automatic ban cleaner...');
        $bans = Ban::all();

        if (!is_null($bans))
        {
          foreach($this->bans as $ban)
          {
              $bannedUntil = Carbon::parse($ban->bannedUntil);

              if ($bannedUntil->equalTo(now()))
              {
                  Log::debug('Deleted ban ' . $ban->id . ' belonging to ' . $ban->user->name);
                  $ban->delete();
              }
          }
        }

    }
}
