<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Shift extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'day' => $this->day,
            'time' => $this->time,
            'duration' => $this->duration,
            'category' => $this->help_category->name,
            'shiftroles' => Shiftrole::collection($this->shiftroles)->shift_id($this->id),
        ];
    }
}
