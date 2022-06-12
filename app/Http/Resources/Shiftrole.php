<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ShiftroleCollection extends ResourceCollection
{
    protected $my_shift_id = null;

    public function shift_id($id)
    {
        $this->my_shift_id = $id;

        return $this;
    }

    public function toArray($request)
    {
        return $this->collection->map(function (Shiftrole $resource) use ($request) {
            return $resource->shift_id($this->my_shift_id)->toArray($request);
        })->all();
    }
}

class Shiftrole extends JsonResource
{
    protected $my_shift_id = null;

    public function shift_id($id)
    {
        $this->my_shift_id = $id;

        return $this;
    }

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
            'status' => $this->status($this->my_shift_id),
        ];
    }

    public static function collection($resource)
    {
        return new ShiftroleCollection($resource);
    }
}
