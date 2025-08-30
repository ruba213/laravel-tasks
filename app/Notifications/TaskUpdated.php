<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskUpdated extends Notification
{
    use Queueable;
  protected $task;
  protected $action;
    protected $changes;

    /**
     * Create a new notification instance.
     */
    public function __construct($task, $action,$changes = [])
    {
 $this->task = $task;
$this->action=$action;
 $this->changes = $changes;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
         switch ($this->action) {
            case 'created':
                $message = 'تمت إضافة مهمة جديدة بعنوان: ' . $this->task->title;
                break;
            case 'updated':
                if (!empty($this->changes)) {
                    $changedFields = [];
                    foreach ($this->changes as $field => $newValue) {
                        $changedFields[] = "$field => $newValue";
                    }
                    $message = 'تم تعديل المهمة #' . $this->task->id . '. التغييرات: ' . implode(', ', $changedFields);
                } else {
                    $message = 'تم تعديل المهمة #' . $this->task->id;
                }
                break;
            case 'deleted':
                $message = 'تم حذف المهمة بعنوان: ' . $this->task->title;
                break;
            default:
                $message = 'إجراء غير معروف على المهمة.';
        }
return [
            'message' => $message,
            'task_id' => $this->task->id ?? null,
        ];
    }
}
