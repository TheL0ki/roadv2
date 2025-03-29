<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
                'display' => $this->displayName,
                'active' => $this->active === 1 ? true : false,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
