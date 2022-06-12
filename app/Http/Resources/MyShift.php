<?php

namespace App\Http\Resources;

use App\Models\Shiftrole;
use Illuminate\Http\Resources\Json\JsonResource;

class MyShift extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $shiftrole = Shiftrole::find($this->pivot->shiftrole_id);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'day' => $this->day,
            'time' => $this->time,
            'duration' => $this->duration,
            'category' => $this->help_category->name,
            'shiftroles' => [
                [
                    'name' => $shiftrole->name,
                    'id' => $shiftrole->id,
                    'status' => 'assigned',
                ],
            ],
        ];
    }
}
