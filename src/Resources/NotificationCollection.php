<?php
namespace Viauco\Messenger\Resources;

class NotificationCollection extends Collections
{
    public function toArray($request)
    {
        return [

            'meta' => [
                //'total'        => $this->total(),
                'count'        => $this->count(),
                'per_page'     => $this->perPage(),
                'current_page' => $this->currentPage(),
                //'total_pages'  => $this->lastPage(),
                'next' => $this->nextPageUrl(),
				'prev' => $this->previousPageUrl()
            ],
            'items' => Notification::collection($this->collection),
        ];
    }
}
