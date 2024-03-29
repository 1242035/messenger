<?php
namespace Viauco\Messenger\Traits;

use Viauco\Messenger\Models;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait     Messagable
 *
 * @package  Viauco\Messenger\Traits
 *
 * @property  int                                       id
 * @property  \Illuminate\Database\Eloquent\Collection  discussions
 * @property  \Illuminate\Database\Eloquent\Collection  participations
 * @property  \Illuminate\Database\Eloquent\Collection  messages
 */
trait Messagable
{
    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function discussions()
    {
        return $this->morphToMany(
            config('messenger.discussions.model', Models\Discussion::class),
            config('messenger.users.morph', 'participable'),
            config('messenger.participations.table', 'participations')
        );
    }

    /**
     * Participations relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function participations()
    {
        return $this->morphMany(
            config('messenger.participations.model', Models\Participation::class),
            config('messenger.users.morph', 'participable')
        );
    }

    /**
     * Message relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function messages()
    {
        return $this->morphMany(
            config('messenger.messages.model', Models\Message::class),
            config('messenger.users.morph', 'participable')
        );
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function newMessagesCount()
    {
        return $this->discussionsWithNewMessages()->count();
    }

    /** 
     * Returns all discussions IDs with new messages.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function discussionsWithNewMessages()
    {
        $participationsTable = config('messenger.participations.table', 'participations');
        $discussionsTable    = config('messenger.discussions.table', 'discussions');

        return $this->discussions()->where(function (Builder $query) use ($participationsTable, $discussionsTable) {
            $query->whereNull("$participationsTable.last_read");
            $query->orWhere(
                "$discussionsTable.updated_at", '>', $this->getConnection()->raw("$participationsTable.last_read")
            );
        })->get();
    }

    /* -----------------------------------------------------------------
     |  Eloquent Methods
     | -----------------------------------------------------------------
     */

    /**
     * Define a polymorphic one-to-many relationship.
     *
     * @param  string  $related
     * @param  string  $name
     * @param  string  $type
     * @param  string  $id
     * @param  string  $localKey
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    abstract public function morphMany($related, $name, $type = null, $id = null, $localKey = null);

    /**
     * Define a polymorphic many-to-many relationship.
     *
     * @param  string  $related
     * @param  string  $name
     * @param  string  $table
     * @param  string  $foreignPivotKey
     * @param  string  $relatedPivotKey
     * @param  string  $parentKey
     * @param  string  $relatedKey
     * @param  bool  $inverse
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    abstract public function morphToMany(
        $related, $name, $table = null, $foreignPivotKey = null, $relatedPivotKey = null, $parentKey = null,
        $relatedKey = null, $inverse = false
    );
}
