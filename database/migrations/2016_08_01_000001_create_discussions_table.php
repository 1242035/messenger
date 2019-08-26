<?php

use Viauco\Messenger\Bases\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateDiscussionsTable
 *
 *
 * @see Viauco\Messenger\Models\Discussion
 */
class CreateDiscussionsTable extends Migration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * CreateDiscussionsTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable(
            config('messenger.discussions.table', 'discussions')
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
            $table->string('key');
            $table->string('subject')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
