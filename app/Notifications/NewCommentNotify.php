<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotify extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $comment, $post;
    public function __construct($comment, $post)
    {
        $this->comment = $comment;
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        //$notifiable this the user that will resive the notfication i can accsess any column link $notifiable->name
        // if we need to check how the notfication will sent we can add a column to the user true or flase
        // $via =['database']
        //if($notifiable->sms_notify==true){
        //    $via[]='nexmo'; add a new value to the array in addtion to the database value $via =['database','nexmo']
        //}
        //if($notifiable->mail_notify==true){
        //    $via[]='mail';
        //}
        //return $via

        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // we can user to database same as to array but to array used to database and any brodcast like pusher
    // we can use to methods and this case to database will save to database and to array will use with pusher
    public function toArray(object $notifiable): array
    {
        return [
            'user_id'=>$this->comment->user_id,
            'user_name'=>auth()->user()->name,
            'post_title'=>$this->post->title,
            'comment'=>$this->comment->comment,
            'post_slug'=>$this->post->slug,
            'link'=>route('frontend.post.show',$this->post->slug)
        ];
    }
    // we can remove toBroadcast if the data to broadcast the same that stored in database so we you use to array only
    // public function toBroadcast(object $notifiable): array
    // {
    //     return [
    //         'user_id'=>$this->comment->user_id,
    //         'user_name'=>auth()->user()->name,
    //         'post_title'=>$this->post->title,
    //         'comment'=>$this->comment->comment,
    //         'link'=>route('frontend.post.show',$this->post->slug)
    //     ];
    // }
}
