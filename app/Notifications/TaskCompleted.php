<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    protected array $mailInfo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $mailInfo)
    {
        $this->mailInfo = $mailInfo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        info("mailInfo");
        info($this->mailInfo);
        info("Notifiable");
        info($notifiable);
        info("Array");
        info($this->mailInfo['ecran']);

        //return $this->view('mail');
        /*(new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');*/
        return (new MailMessage)
            ->subject('Payment confirmation')
            ->view($this->mailInfo['ecran']); // , ['invoice' => $this->invoice]
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->mailInfo;
    }
}
