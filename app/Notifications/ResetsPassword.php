<?php
namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends ResetPassword
{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('no-reply@cryptolending.org', 'CLP Coin')
            ->subject('Your Subject')
            ->greeting('Dear '.$this->name. ',')
            //->greeting('Dear Your')
            ->line('1We are sending this email because we recieved a forgot password request.')
            ->action('Reset Password', url( route('password.reset', $this->token, false)))
            ->line('If you did not request a password reset, no further action is required. Please contact us if you did not submit this request.');
    }
}