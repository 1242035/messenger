<?php
namespace Viauco\Messenger\Models;

use Viauco\Messenger\Contracts\Attachment as AttachmentContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
/**
 * Class     Participant
 *
 * @package  Viauco\Messenger\Models
 *
 * @property  int                                            id
 * @property  int                                            discussion_id
 * @property  \Viauco\Messenger\Models\Discussion  discussion
 * @property  string                                         participable_type
 * @property  int                                            participable_id
 * @property  \Illuminate\Database\Eloquent\Model            participable
 * @property  \Carbon\Carbon                                 last_read
 * @property  \Carbon\Carbon                                 created_at
 * @property  \Carbon\Carbon                                 updated_at
 * @property  \Carbon\Carbon                                 deleted_at
 */
class Attachable extends Model implements AttachmentContract
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use SoftDeletes;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = [
        'attchable_type',
        'attachable_id',
        'discussion_id',
        'path',
        'mime',
        'size',
        'origin',
        'ext',
        'type'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'              => 'string',
        'attachable_id'   => 'string',
    ];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if( null !== config('messenger.attachments.connection') )
        {
            $this->setConnection(config('messenger.attachments.connection'));
        }

        $this->setTable(config('messenger.attachments.table', 'attachments') );
    }

    /**
     * Participable relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachable()
    {
        return $this->morphTo();
    }

    public function author()
    {
        return $this->participable();
    }

    /**
     * Participable relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function participable()
    {
        return $this->morphTo();
    }

    public function scopeForDiscussion(Builder $query, $discussionId)
    {
        return $query->where("discussion_id", '=', $discussionId);
    }
}
