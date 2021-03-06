<?php

namespace App\Notifications;

use App\Task;
use App\Comment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentSubmited extends Notification
{
    use Queueable;

    protected $task;
    protected $comment;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task, Comment $comment, User $user)
    {
        $this->task = $task;
        $this->comment = $comment;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'task' => $this->task,
            'comment' => $this->comment,
            'user' => $this->user,
        ];
    }

    public static function fromDatabase($notifiable_id, $data)
    {
        $user = User::find($data->user->id);
        $task = Task::find($data->task->id);
        $comment = Comment::find($data->comment->id);

        return [
            'user' => $user,
            'task' => $task,
            'project' => $task->project,
            'comment' => $comment,
        ];
    }
}
