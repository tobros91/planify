<?php

namespace App\Notifications;

use App\Project;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvitedToProject extends Notification
{
    use Queueable;

    protected $project;
    protected $user;
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Project $project, User $user, $message)
    {
        $this->project = $project;
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            'project' => $this->project,
            'user' => $this->user,
            'message' => $this->message
        ];
    }


    public static function fromDatabase($notifiable_id, $data)
    {
        $user = User::find($data->user->id);
        $project = Project::find($data->project->id);
        $canRespond = $project->team()
                              ->where('user_id', $notifiable_id)
                              ->wherePivot('accepted_at', null)
                              ->wherePivot('rejected_at', null)
                              ->exists();

        return [
            'user' => $user,
            'project' => $project,
            'message' => $data->message,
            'canRespond' => $canRespond,
        ];
    }
}
