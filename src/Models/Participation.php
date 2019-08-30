<?php
namespace Viauco\Messenger\Models;

use Viauco\Messenger\Contracts\Participation as ParticipantContract;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class Participation extends Model implements ParticipantContract
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
        'discussion_id',
        'participable_type',
        'participable_id',
        'last_read',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_read', 'deleted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'              => 'string',
        'participable_id' => 'string',
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
        
        if( null !== config('messenger.participations.connection') )
        {
            $this->setConnection(config('messenger.participations.connection'));
        }

        $this->setTable(config('messenger.participations.table', 'participations') );
    }

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Discussion relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discussion()
    {
        return $this->belongsTo(
            config('messenger.discussions.model', Discussion::class)
        );
    }

    public function information()
    {
        return $this->hasOne(
            config('messenger.information.model', Information::class)
        );
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

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the participable string info.
     *
     * @return string
     */
    public function stringInfo()
    {
        return $this->participable->getAttribute('name');
    }
}
