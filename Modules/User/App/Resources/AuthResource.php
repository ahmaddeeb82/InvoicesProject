<?php

namespace Modules\User\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'user id'=> $this['id'],
            'token' => $this['token'],
            'is admin' => $this['isAdmin'],
            'has pdf' => $this['hasPdf'],
            'has excel' => $this['hasExcel'],
            'session_id' => $this['session_id'],
        ];
    }
}
