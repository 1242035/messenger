<?php
namespace Viauco\Messenger\Models;

use Viauco\Messenger\Contracts\Message as MessageContract;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class     Message
 *
 * @package  Viauco\Messenger\Models
 *
 * @property  int                                            id
 * @property  int                                            discussion_id
 * @property  string                                         participable_type
 * @property  int                                            participable_id
 * @property  int                                            body
 * @property  \Carbon\Carbon                                 created_at
 * @property  \Carbon\Carbon                                 updated_at
 *
 * @property  \Viauco\Messenger\Models\Discussion  discussion
 * @property  \Illuminate\Database\Eloquent\Model            participable
 * @property  \Illuminate\Database\Eloquent\Model            author
 * @property  \Illuminate\Database\Eloquent\Collection       participations
 * @property  \Illuminate\Database\Eloquent\Collection       recipients
 */
class Message extends Mongo implements MessageContract
{
    use SoftDeletes;
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['discussion'];

    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = [
        'discussion_id',
        'body',
        'type',
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
        'discussion_id'   => 'int',
        'participable_id' => 'int',
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

        if( null !== config('messenger.messages.connection') )
        {
            $this->setConnection(config('messenger.messages.connection'));
        }

        $this->setTable(config('messenger.messages.table', 'messages') );

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

    /**
     * User/Author relationship (alias).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
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

    public function attachments()
    {
        return $this->morphMany(config('messenger.attachments.model', Attachable::class), 'attachable');
    }

    /**
     * Participations relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
     /**
      * Add a participable to discussion.
      *
      * @param  \Illuminate\Database\Eloquent\Model  $participable
      *
      * @return \Viauco\Messenger\Models\Participation|mixed
      */
     /*public function addAttachable(EloquentModel $attachable)
     {
         $morph = config('messenger.attachables.morph', 'attachable');

         return $this->attachments()->firstOrCreate([
             "{$morph}_id"   => $attachable->getKey(),
             "{$morph}_type" => $attachable->getMorphClass(),
             'message_id' => $this->id,
         ]);
     }*/

     /**
      * Add many participables to discussion.
      *
      * @param  \Illuminate\Support\Collection|array  $participables
      *
      * @return \Illuminate\Database\Eloquent\Collection
      */
     /*public function addAttachables($attachables)
     {
         foreach ($attachables as $attachable) {
             $this->addAttachable($attachable);
         }

         return $this->attachments;
     }*/

     /**
      * Remove a participable from discussion.
      *
      * @param  \Illuminate\Database\Eloquent\Model  $participable
      * @param  bool                                 $reload
      *
      * @return int
      */
     /*public function removeAttachable(EloquentModel $attachable, $reload = true)
     {
         return $this->removeAttachables([$attachable], $reload);
     }*/

     /**
      * Remove many participables from discussion.
      *
      * @param  \Illuminate\Support\Collection|array  $participables
      * @param  bool   $reload
      *
      * @return int
      */
     /*public function removeAttachables($attachables, $reload = true)
     {
         $morph   = config('messenger.attachable.morph', 'attachable');
         $deleted = 0;

         foreach ($attachables as $attachable) {
             $deleted += $this->attachments()
                 ->where("{$morph}_type", '=', $attachable->getMorphClass())
                 ->where("{$morph}_id", '=', $attachable->getKey())
                 ->where('message_id', '=', $this->id)
                 ->delete();
         }

         if ($reload) {
             $this->load(['attachments']);
         }

         return $deleted;
     }*/
}
