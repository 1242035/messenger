<?php

use Viauco\Messenger\Bases\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateParticipationsTable
 *
 *
 * @see Viauco\Messenger\Models\Participation
 */
class CreateParticipationsTable extends Migration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * CreateParticipantsTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable(
            config('messenger.participations.table', 'participations')
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
            $table->timestamp('last_read')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
