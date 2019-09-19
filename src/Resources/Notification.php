<?php
namespace Viauco\Messenger\Resources;

class Notification extends Item
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'data'       => $this->data,
            //'type'       => $this->notifiable,
            'readAt'     => $this->read_at,
            'createdAt'  => $this->created_at,
            'updatedAt'  => $this->updated_at,
        ];
    }
}
