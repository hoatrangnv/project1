<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotifySponsor extends Notification
{
    use Queueable;
    public $sponsor;
    public $link_active;

    public function __construct($sponsor, $link_active)
    {
        $this->sponsor = $sponsor;
        $this->link_active = $link_active;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('no-reply@clpcoin.co', 'CLP')
            ->subject('CLP Coin')
            // ->cc($dataSendMail['mail_to'], $this->user->name)
            ->greeting('Dear '.$this->sponsor->name. ',')
            ->line('Congratulations, you have a new member yyy joining CLP.')
            ->line('To ensure the new member is successful and understands our business model and is geared for success, please call him/her and set up a meeting as soon as possible.')
            ->action("Anytime you need any help or support, Please contact your sponsor or visit the FAQ section on our member website ", $this->link_active)
            ->line('Best regards')
            ->line('The CLP Team')
            ->line('"Good energy always wins!"');
    }
}