<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Attachable;
use Viauco\Messenger\Resources\AttachableCollection;

class AttachmentController extends Controller
{

    public function GetAll( $discussionId )
    {
        try
        {
            $params = request()->all();

            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.attachments.paginate.limit', 25); }
            if( ! isset( $params['page'] ) ){ $params['page'] = 1; } else { $params['page'] = (int)$params['page']; }

            $type = null;
            try {
                $type = explode(',', $params['type']);
                if( ! is_array( $type ) ) {
                    $type = (array)$type;
                }
            }catch(\Exception $ee) {}

            $attachments = Attachable::notDeleted()
                                      ->forDiscussion($discussionId)
                                      ->where( function ($query) use ($type) {
                                          if( isset( $type ) && is_array($type) && count( $type ) > 0 )
                                          {
                                              $query->whereIn('type', (array)$type);
                                          }
                                      })
                                      ->simplePaginate((int)$params['per_page']);

            return $this->_success( new AttachableCollection( $attachments ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );
            return $this->_error($e);
        }
    }
}
