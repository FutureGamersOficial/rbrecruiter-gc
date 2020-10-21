<?php


namespace App\Traits;


use App\Facades\Options;

trait Cancellable
{

    public function chooseChannelsViaOptions()
    {
        $channels = [];

        if (Options::getOption('enable_slack_notifications') == 1)
        {
            array_push($channels, 'slack');
        }
        elseif(Options::getOption('enable_email_notifications') == 1)
        {
            array_push($channels, 'email');
        }

        return $channels;
    }

    public function channels()
    {
        return ['mail'];
    }

    public function via($notifiable)
    {
        if ($this->optOut($notifiable))
        {
            return [];
        }

        return $this->channels();
    }


    public function optOut($notifiable)
    {
        return false;
    }

}
