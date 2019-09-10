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
            'firstName' => $this->first_name,
            'lastName'  => $this->last_name,
            'fullName'  => $this->first_name . ' ' . $this->last_name,
            'avatar'     => $this->cover,
            'birthday'   => $this->birthday,
            'type'       => $this->type_register,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
