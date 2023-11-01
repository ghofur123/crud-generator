<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
'ext_name' => $this->ext_name,
'type' => $this->type,
'size' => $this->size,
'path' => $this->path,
'url' => $this->url,
'user_id' => $this->user_id,
        ];
    }
}
