<?php

namespace Viauco\Messenger\Resources;

class AttachableCollection extends Collections
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

             'meta' => [
                 //'total'        => $this->total(),
                 'count'        => $this->count(),
                 'per_page'     => $this->perPage(),
                 'current_page' => $this->currentPage(),
                 //'total_pages'  => $this->lastPage(),
                 'next' => $this->nextPageUrl(),
 				 'prev' => $this->previousPageUrl()
             ],
             'items' => Attachable::collection($this->collection),
         ];
     }
}
