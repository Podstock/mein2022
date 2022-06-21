<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class Bordentry extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => Str::markdown($this->content, ['html_input' => 'strip']),
            'name' => $this->user->name,
            'user_id' => $this->user->id,
            'created' => \Carbon\Carbon::parse($this->created_at)->locale('de')->diffForHumans(),
            'avatar' => $this->user->avatar_tiny,
        ];
    }
}
