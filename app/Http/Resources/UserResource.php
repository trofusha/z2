<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
            schema: 'User',
            properties: [
        new OAT\Property(property: 'id', type: 'integer', format: 'int64', minimum: 1),
        new OAT\Property(property: 'email', type: 'string', format: 'email'),
        new OAT\Property(property: 'name', type: 'string'),
        new OAT\Property(property: 'email_verified_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OAT\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
            ],
    )]
class UserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        unset($this->company_name);
        return parent::toArray($request);
    }
}
