<?php
namespace Viauco\Messenger\Models;

//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Viauco\Messenger\Traits\PrefixedModel;

/**
 * Class     Model
 *
 * @package  Viauco\Messenger\Models
 */
abstract class Model extends Eloquent
{
    use PrefixedModel;

    protected $connection = 'mongodb';

    public $incrementing = false;
    
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
        $this->setPrefix(config('messenger.database.prefix'));

        parent::__construct($attributes);
    }
}
