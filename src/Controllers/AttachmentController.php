<?php
namespace Viauco\Messenger\Controllers;

use Viauco\Messenger\Models\Attachable;
use Viauco\Messenger\Resources\AttachableCollection;

class AttachmentController extends Controller
{

    public function GetAll($discussionId)
    {
        try
        {
            $params = request()->all();

            if( ! isset( $params['per_page'] ) ){ $params['per_page'] = config('messenger.attachments.piginate.limit', 25); }

            $params['page'] = (int)$params['page'];

            $attachments = Attachable::notDeleted()
                                      ->forDiscussion($discussionId)
                                      ->where( function ($query) use ($params) {
                                          if( isset( $params['type'] ) )
                                          {
                                              if( is_string( $params['type'] ) )
                                              {
                                                  $query->where('type', '=', $params['type']);
                                              }
                                              else if( is_array( $params['type'] ) )
                                              {
                                                  $query->whereIn('type', $params['type']);
                                              }
                                          }
                                      })
                                      ->paginate((int)$params['per_page']);

            return $this->_success( new AttachableCollection( $attachments ) );
        }
        catch(\Exception $e)
        {
            logger()->error( $e );
            return $this->_error($e);
        }
    }
}
