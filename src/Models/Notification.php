<?php
namespace Viauco\Messenger\Models;

use Viauco\Messenger\Contracts\Notification as NotificationContract;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Builder;
/**
 * Class     Discussion
 *
 * @package  Viauco\Messenger\Models
 *
 */
class Notification extends Model implements NotificationContract
{

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {

        parent::__construct($attributes);

        if( null !== config('messenger.notifications.connection') )
        {
            $this->setConnection(config('messenger.notifications.connection'));
        }

        $this->setTable(config('messenger.notifications.table', 'notifications') );
    }
    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'id'      => 'string'
    ];

    /**
     * Get the notifiable entity that the notification belongs to.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Mark the notification as read.
     *
     * @return void
     */
    public function markAsRead()
    {
        if (is_null($this->read_at))
        {
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * Mark the notification as unread.
     *
     * @return void
     */
    public function markAsUnread()
    {
        if (! is_null($this->read_at))
        {
            $this->forceFill(['read_at' => null])->save();
        }
    }

    /**
     * Determine if a notification has been read.
     *
     * @return bool
     */
    public function read()
    {
        return $this->read_at !== null;
    }

    /**
     * Determine if a notification has not been read.
     *
     * @return bool
     */
    public function unread()
    {
        return $this->read_at === null;
    }

    public function scopeForModel(Builder $query, EloquentModel $model)
    {
        return $query->where("notifiable_type", '=', $model->getMorphClass())
            ->where("notifiable_id", '=', (string)$model->getKey());
    }
    /**
     * Create a new database notification collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Notifications\DatabaseNotificationCollection
     */
    public function newCollection(array $models = [])
    {
        return new DatabaseNotificationCollection($models);
    }
}
