<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Attributes as OAT;

#[
    OAT\Schema(
            schema: 'ValidationErrors',
            required: ['message', 'errors'],
            properties: [
        new OAT\Property('message', type: 'string'),
        new OAT\Property('errors', type: 'object', example: ['field' => ['string']]),
            ],
    ),
    OAT\Response(
            response: 'ValidationErrorsResponse',
            description: 'Validation errors',
            content: new OAT\JsonContent(ref: '#/components/schemas/ValidationErrors'),
    ),
    OAT\Schema(
            schema: 'Paginator',
            required: ['current_page', 'data', 'first_page_url', 'from', 'last_page', 'last_page_url', 'links', 'next_page_url', 'path', 'per_page', 'prev_page_url', 'to', 'total'],
            properties: [
        new OAT\Property('current_page', type: 'integer', minimum: 1),
        new OAT\Property('data', type: 'array', items: new OAT\Items(type: 'object')),
        new OAT\Property('first_page_url', type: 'string'),
        new OAT\Property('from', type: 'integer', minimum: 1),
        new OAT\Property('last_page', type: 'integer', minimum: 1),
        new OAT\Property('last_page_url', type: 'string'),
        new OAT\Property('links', type: 'array', items: new OAT\Items(required: ['url', 'label', 'active'], properties: [
                    new OAT\Property('url', type: 'string', nullable: true),
                    new OAT\Property('label', type: 'string'),
                    new OAT\Property('active', type: 'boolean'),
                        ])),
        new OAT\Property('next_page_url', type: 'string', nullable: true),
        new OAT\Property('path', type: 'string', nullable: true),
        new OAT\Property('per_page', type: 'integer', minimum: 1),
        new OAT\Property('prev_page_url', type: 'string', nullable: true),
        new OAT\Property('to', type: 'integer', minimum: 1),
        new OAT\Property('total', type: 'integer', minimum: 1),
            ],
    ),
    OAT\Response(
            response: 'Paginator',
            description: 'Paginator',
            content: new OAT\JsonContent(ref: '#/components/schemas/Paginator'),
    ),
] final class ApiResponse
{
    
}
