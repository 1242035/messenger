<?php 
namespace Viauco\Messenger\Contracts;

/**
 * Interface  Message
 *
 * @package   Viauco\Messenger\Contracts
 *
 * @property  int                                            id
 * @property  int                                            discussion_id
 * @property  \Viauco\Messenger\Models\Discussion  discussion
 * @property  int                                            user_id
 * @property  \Illuminate\Database\Eloquent\Model            user
 * @property  \Illuminate\Database\Eloquent\Model            author
 * @property  int                                            body
 * @property  \Carbon\Carbon                                 created_at
 * @property  \Carbon\Carbon                                 updated_at
 * @property  \Illuminate\Database\Eloquent\Collection       participations
 * @property  \Illuminate\Database\Eloquent\Collection       recipients
 */
interface Notification
{
    
}
