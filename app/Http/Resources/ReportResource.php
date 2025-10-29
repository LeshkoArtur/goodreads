<?php

namespace App\Http\Resources;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Report
 */
class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type->value,
            'reportable_id' => $this->reportable_id,
            'reportable_type' => $this->reportable_type,
            'description' => $this->description,
            'status' => $this->status->value,
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'username' => $this->user->username ?? null,
                ];
            }),
            'reportable' => $this->whenLoaded('reportable', function () {
                return [
                    'id' => $this->reportable->id,
                    'type' => class_basename($this->reportable_type),
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
