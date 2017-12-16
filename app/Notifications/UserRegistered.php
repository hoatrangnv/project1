<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class UserRegistered extends Notification
{
    use Queueable;

    const SUCCESS_REPORT = 2;
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
        if($this->link_active == self::SUCCESS_REPORT){
            return (new MailMessage)
                ->from('no-reply@clpcoin.co', 'CLP')
                ->subject('CLP Coin')
                // ->cc($dataSendMail['mail_to'], $this->user->name)
                ->greeting('Dear '.$this->user->name. ',')
                ->line('Congratulations, you have now successfully joined CLP.')
                ->line('To get the possible best start in your new CLP business please contact the person who introduced you to CLP, your sponsor, and set up a meeting as soon as possible. He or she will help you to succeed, as your success is his/her success too.')
                ->line('Important: the first step you then need to take is to activate your CLP account. This is necessary to start earning commission and daily interest')
                ->line('Please refer to the “How to activate account” in FAQ section.')
                ->line('Anytime you need any additional help or support, please visit our FAQ section.')
                ->line('We wish you the best of luck.')
                ->line('Best regards')
                ->line('The CLP Team')
                ->line('"Good energy always wins!"');
        }
        return (new MailMessage)
            ->from('no-reply@clpcoin.co', 'CLP')
            ->subject('Welcome to the CLP Coin')
            // ->cc($dataSendMail['mail_to'], $this->user->name)
            ->greeting('Dear '.$this->user->name. ',')
            ->line('Welcome to the CLP Coin.')
            ->action('Active Account', $this->link_active)
            ->line('Link active account will expire in 1 days.')
            ->line('If you did not request register account, no further action is required. Please contact us if you did not submit this request.');
    }
}