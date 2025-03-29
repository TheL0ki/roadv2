<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'shift',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'display' => $this->display,
                'color' => $this->color,
                'textColor' => $this->textColor,
                'hours' => $this->hours,
                'flexLoc' => $this->flexLoc === 1 ? true : false,
                'override' => $this->override === 1 ? true : false,
                'isHoliday' => $this->isHoliday === 1 ? true : false,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
