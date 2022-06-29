<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class pasienResource extends JsonResource
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
            "id" => $this->id,
            "nama_lengkap" => $this->nama_lengkap,
            "nomor_hp" => $this->nomor_hp,
            "tanggal_lahir" => $this->tanggal_lahir,
            "kelamin" => $this->kelamin,
            "alamat" => $this->alamat
        ];
    }
}
