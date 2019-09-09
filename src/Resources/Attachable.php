<?php

namespace Viauco\Messenger\Resources;

class Attachable extends Item
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
            'id'         => $this->_id,
            'path'       => $this->path,
            'type'       => $this->type,
            'mime'       => $this->mime,
            'size'       => $this->size
        ];
    }
}
