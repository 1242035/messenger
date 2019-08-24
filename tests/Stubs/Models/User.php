<?php namespace Viauco\Messenger\Tests\Stubs\Models;

use Viauco\Messenger\Traits\Messagable;
use Viauco\Messenger\Models\Model;

/**
 * Class     User
 *
 * @package  Viauco\Messenger\Tests\Models
 */
class User extends Model
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Messagable;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    protected $fillable = ['name', 'email'];

    protected $casts = [
        'id' => 'integer',
    ];
}
