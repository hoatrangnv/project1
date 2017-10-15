<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
class WithDrawConfirm extends Notification
{
    public $user;
    public $coinData;
    public $linkConfirm;
    public function __construct($user, $coinData, $linkConfirm)
    {
        $this->user = $user;
        $this->coinData = $coinData;
        $this->linkConfirm = $linkConfirm;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail()
    {
        return (new MailMessage)
            ->from('no-reply@clpcoin.co', 'CLP')
            ->subject('Withdraw '.($this->coinData['type'] == 'btc' ? 'BTC' : 'CLP').' Coin confirm')
            ->greeting('Dear '.$this->user->name. ',')
            ->line('A request to withdraw '.$this->coinData['amount'].' '.($this->coinData['type'] == 'btc' ? 'BTC' : 'CLP').' from your CLP account to address '.$this->coinData['address'].' was just made.')
            ->action('Confirm link', $this->linkConfirm)
            ->line('Link confirmation withdrawal will expire in 30 mins.')
            ->line('Welcome to the CLP Coin.');
    }
}