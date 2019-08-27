<?php

namespace Viauco\Messenger\Resources;

class User extends Item
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
            'email'      => $this->email,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'full_name'  => $this->first_name . ' ' . $this->last_name,
            'avatar'     => $this->avatar,
            'birthday'   => $this->birthday,
            'type'       => $this->type_register,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
