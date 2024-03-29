<?php
namespace Viauco\Messenger\Models;

//use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Viauco\Messenger\Traits\Notifiable;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
/**
 * Class     Model
 *
 * @package  Viauco\Messenger\Models
 */
abstract class Model extends Eloquent
{
    use Notifiable, HybridRelations;

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
        $this->setConnection(config('messenger.database.connection'));

        parent::__construct($attributes);
    }

    protected static function keyName()
    {
        return (new static)->getKeyName();
    }

    protected static function tableName()
    {
        return (new static)->getTable();
    }

    /**
     * Scope Deleted associated with.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model    $participable
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }
}
