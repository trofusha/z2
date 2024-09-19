<?php

namespace App\Enums;

use App\Traits\EnumFromName;
use App\Traits\EnumToArray;
use Illuminate\Contracts\Support\Arrayable;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
            schema: 'UserRole',
            required: ['code', 'title'],
            properties: [
        new OAT\Property('code', type: 'string', example: 'ADMINISTRATOR'),
        new OAT\Property('title', type: 'string', example: 'Администратор'),
            ],
            type: 'object',
    )]
enum UserRole: string implements Arrayable
{

    use EnumToArray,
        EnumFromName;

    case ADMINISTRATOR = 'ADMINISTRATOR';
    case USER = 'USER';

    public function title(): string
    {
        return __($this->value);
    }

    /**
     * @return array{code: string, title: string}
     */
    public function toArray(): array
    {
        return [
            'code' => $this->name,
            'title' => $this->title(),
        ];
    }
}
