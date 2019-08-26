<?php

use Viauco\Messenger\Bases\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateMessagesTable
 *
 *
 * @see Viauco\Messenger\Models\Message
 */
class CreateMessagesTable extends Migration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * CreateMessagesTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable(
            config('messenger.messages.table', 'messages')
        );
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->createSchema(function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('discussion_id');
            $table->morphs(config('messenger.users.morph', 'participable'));
            $table->text('body');
            $table->string('type')->default('text');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
