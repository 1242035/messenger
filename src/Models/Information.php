<?php
namespace Viauco\Messenger\Models;

use Viauco\Messenger\Contracts\Information as InformationContract;
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
class Information extends Model implements InformationContract
{
    use SoftDeletes;
    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = [
        'last_active',
        'last_message_id',
        'participable_id'
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
        'last_active'     => 'datetime',
        'last_message_id' => 'string',
        'participable_id' => 'string'
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
        
        if( null !== config('messenger.informations.connection') )
        {
            $this->setConnection(config('messenger.informations.connection'));
        }

        $this->setTable(config('messenger.informations.table', 'informations') );
    }

    /**
     * User/Author relationship (alias).
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function message()
    {
        return $this->beleongsTo( config('messenger.participations.model', Participation::class) );
    }
}
