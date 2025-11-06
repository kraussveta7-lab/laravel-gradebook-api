<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'student_id_number' => $this->student_id_number,
            'grades'=>GradeResource::collection($this->whenLoaded("grades")),
            'subjects'=>SubjectResource::collection($this->whenLoaded('subjects')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
