<?php
namespace Viauco\Messenger\Contracts;

/**
 * Interface  Participation
 *
 * @package   Viauco\Messenger\Contracts
 *
 * @property  int                                            id
 * @property  int                                            discussion_id
 * @property  \Viauco\Messenger\Models\Discussion  discussion
 * @property  string                                         participable_type
 * @property  int                                            participable_id
 * @property  \Illuminate\Database\Eloquent\Model            participable
 * @property  \Carbon\Carbon                                 last_read
 * @property  \Carbon\Carbon                                 created_at
 * @property  \Carbon\Carbon                                 updated_at
 * @property  \Carbon\Carbon                                 deleted_at
 */
interface Attachment
{
    /**
     * Participable relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachable();

}
