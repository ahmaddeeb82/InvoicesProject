<?php

namespace Modules\User\App\resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'password' => Crypt::decryptString($this->password),
            'permissions' => $this->getAllPermissions()->pluck('name'),
        ];
    }
}
