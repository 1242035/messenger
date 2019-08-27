<?php
namespace Viauco\Messenger\Resources;

class MessageCollection extends Collections
{
    public function toArray($request)
    {
        return [
            
            'meta' => [
                'total'        => $this->total(),
                'count'        => $this->count(),
                'per_page'     => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages'  => $this->lastPage()
            ],
            'items' => Message::collection($this->collection),
        ];
    }
}
