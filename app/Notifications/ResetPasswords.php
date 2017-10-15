<?php
namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
class ResetPasswords extends ResetPassword{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('no-reply@clpcoin.co', 'CLP')
            ->subject('Reset Password')
            //->greeting('Dear '.$this->name. ',')
            //->greeting('Dear Your')
            ->line('We are sending this email because we recieved a forgot password request.')
            ->action('Reset Password', url( route('password.reset', [$this->token, 'email'=>$notifiable->email], false)))
            ->line('Link reset password expire 3 day.')
            ->line('If you did not request a password reset, no further action is required. Please contact us if you did not submit this request.');
    }
}