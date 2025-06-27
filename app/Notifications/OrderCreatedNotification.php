<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Symfony\Component\Intl\Countries;

class OrderCreatedNotification extends Notification
{
    use Queueable;


    public $order ;
    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order=$order ;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array //what chanel you want to user to send your notification . || notifiable object is the user you want to notify him .
    {
        return ['mail' , 'database'];

        // افترض ان user mode has notification_preference json column and user can select what notification arrive to him if he make order . 
        $chanel=['database'];

        if($notifiable->notification_preferences['order_created']['mail'] ?? false){
            $chanel[]='mail';
        }
        if($notifiable->notification_preferences['order_created']['sms'] ?? false){
            $chanel[]='Vonage';
        }
        if($notifiable->notification_preferences['order_created']['broadcast'] ?? false ){
            $chanel[]='broadcast';
        }
        return $chanel ;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $order_number=$this->order->order_number;
       
        $billing_addresses=$this->order->billing;


        // $clint_name=$billing_addresses->first_name.' '.$billing_addresses->last_name; // using access to don't repeat you self .

        // $country=Countries::getName($billing_addresses->country);
        return (new MailMessage)
                    ->subject("New Order Created #{$order_number}")
                    ->greeting("Hi {$notifiable->name} ,")
                    ->from('no-replay@arrzak-store.com' , "Arrzak-Store")
                    ->line("new order #({$order_number})has been created by {$billing_addresses->name} from {$billing_addresses->country_name}")
                    ->action('Notification Action', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

// >line("new order #({$order_number})has been created by {$billing_addresses->name} from {$billing_addresses->country_name}")
    public function toDatabase(object $notifiable):array
    {
        $order_number=$this->order->order_number;
        $billing_addresses=$this->order->billing;
         return [
           
            'body'=>"new order  #({$order_number}) has been created by {$billing_addresses->name} from {$billing_addresses->country_name}  ",
            'icon'=>'fas fa-file' ,
            'url'=>url('/dashboard') ,
            'order_id'=>$this->order->order_id

        ];

    }
}
