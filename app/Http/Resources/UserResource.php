<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data= [
            'name' => $this->name,
            'status'=>$this->status,
            'created_at' => $this->created_at,


        ];
        if($request->is('api/account/user')){
            $data['user_id']=$this->id;
            $data['email']=$this->email;
            $data['phone']=$this->phone;
            $data['country']=$this->country;
            $data['city']=$this->city;
            $data['street']=$this->street;
            $data['image']=$this->image_path;
        }
        return $data;
    }
}
