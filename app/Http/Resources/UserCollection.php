<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
            schema: 'UserCollection',
            type: 'array',
            items: new OAT\Items(ref: '#/components/schemas/User')
            ,
    )]
class UserCollection extends ResourceCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
