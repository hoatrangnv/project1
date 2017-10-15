<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
class ResetsPasswordSuccess extends Notification
{
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail()
    {
        return (new MailMessage)
            ->from('no-reply@clpcoin.co', 'CLP')
            ->subject('Reset password sussefullly')
            ->greeting('Dear '.$this->user->name. ',')
            ->line('Welcome to the CLP Coin.');
    }
}