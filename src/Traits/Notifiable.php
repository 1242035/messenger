<?php
namespace Viauco\Messenger\Traits;

use Illuminate\Notifications\Notifiable as BaseNotifiable;

trait Notifiable
{
    use BaseNotifiable;

    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        return $this->morphMany(\Viauco\Messenger\Models\Notification::class, 'notifiable')
                            ->orderBy('created_at', 'desc');
    }
}