<?php

use Viauco\Messenger\Bases\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class     CreateUsersTable
 *
 */
class CreateUsersTable extends Migration
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * CreateParticipantsTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setTable('users');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Run the migrations.
     */
    public function up()
    {
        $this->createSchema(function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }
}
