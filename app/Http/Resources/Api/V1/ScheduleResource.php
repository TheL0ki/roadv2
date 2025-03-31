<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'schedule',
            'id' => $this->id,
            'attributes' => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'shift_id' => $this->shift_id,
                'flexLoc' => $this->flexLoc === 1 ? true : false,
                'shift' => new ShiftResource($this->shift),
                'user' => new UserResource($this->user),
            ]
        ];
    }
}
