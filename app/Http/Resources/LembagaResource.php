<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LembagaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return
        [
			'npsn' => $this->npsn,
			'nama_lembaga' => $this->nama_lembaga,
			'alamat' => $this->alamat,
        ];
    }
}
