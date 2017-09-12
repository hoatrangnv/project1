<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class UserRegistered extends Notification
{
    use Queueable;
    public $user;
    public $link_active;

    public function __construct($user, $link_active)
    {
        $this->user = $user;
        $this->link_active = $link_active;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('no-reply@cryptolending.org', 'CLP Coin')
            ->subject('Welcome to the crypyto')
            // ->cc($dataSendMail['mail_to'], $this->user->name)
            ->greeting('Dear '.$this->user->name. ',')
            ->line('Welcome to the crypyto.')
            ->action('Active Account', $this->link_active)
            ->line('If you did not request Active Account, no further action is required. Please contact us if you did not submit this request.');
    }
}