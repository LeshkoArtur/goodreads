<?php

namespace App\Http\Resources;

use App\Models\ViewHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ViewHistory
 */
class ViewHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'viewable_id' => $this->viewable_id,
            'viewable_type' => $this->viewable_type,
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'username' => $this->user->username ?? null,
                ];
            }),
            'viewable' => $this->whenLoaded('viewable', function () {
                return [
                    'id' => $this->viewable->id,
                    'type' => class_basename($this->viewable_type),
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
