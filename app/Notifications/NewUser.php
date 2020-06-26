<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

use App\User;
use App\Facades\UUID;

class NewUser extends Notification implements ShouldQueue
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ($notifiable->isStaffMember())
          ? ['slack', 'mail']
          : ['mail'];

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from(config('notification.sender.address'), config('notification.sender.name'))
                    ->subject(config('app.name') . ' - New user')
                    ->line($this->user->name . ' has just registered to our site.')
                    ->line('You are receiving this email because you opted to receive new user notifications.')
                    ->action('View profile', url(route('showSingleProfile', ['user' => $this->user->id])))
                    ->line('Thank you!');
    }

    public function toSlack($notifiable)
    {
      $user = [];

      $user['name'] = $this->user->name;
      $user['email'] = $this->user->email;
      $user['username'] = UUID::toUsername($this->user->uuid);

      $date = \Carbon\Carbon::parse($this->user->created_at);
      $user['created_at'] = $date->englishMonth . ' ' . $date->day . ' ' . $date->year;

        return (new SlackMessage)
                ->success()
                ->content('A new user has signed up!')
                ->attachment(function($attachment) use ($user){

                    $attachment->title('User details')
                               ->fields([
                                  'Email address' => $user['email'],
                                  'Name' => $user['name'],
                                  'Minecraft Username' => $user['username'],
                                  'Registration date' => $user['created_at']
                               ]);

                });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
