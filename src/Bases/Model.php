<?php
namespace Viauco\Messenger\Bases;

use Viauco\Messenger\Traits\PrefixedModel;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class     Model
 *
 * @package  Viauco\Messenger\Bases
 */
abstract class Model extends Eloquent
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use PrefixedModel;
}
