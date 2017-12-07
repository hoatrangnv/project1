<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NotifySponsor extends Notification
{
    use Queueable;
    public $sponsor;
    public $user_name;

    public function __construct($sponsor, $userName)
    {
        $this->sponsor = $sponsor;
        $this->user_name = $userName;
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
            ->line('Congratulations, you have a new member ' . $this->user_name . ' joining CLP.')
            ->line('To ensure the new member is successful and understands our business model and is geared for success, please call him/her and set up a meeting as soon as possible.')
            ->line("Anytime you need any help or support, Please contact your sponsor or visit the FAQ section on our member website ")
            ->line('Best regards')
            ->line('The CLP Team')
            ->line('"Good energy always wins!"');
    }
}