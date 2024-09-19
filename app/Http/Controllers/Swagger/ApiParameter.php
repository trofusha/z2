<?php

namespace App\Http\Controllers\Swagger;

use OpenApi\Attributes as OAT;

#[OAT\Parameter(
            parameter: 'id',
            name: 'id',
            in: 'path',
            required: true,
            schema: new OAT\Schema(type: 'integer', format: 'int64', minimum: 1),
    ), OAT\Parameter(
            parameter: 'page',
            name: 'page',
            in: 'query',
            required: false,
            schema: new OAT\Schema(type: 'integer', minimum: 1, example: 1),
    ), OAT\Parameter(
            parameter: 'per_page',
            name: 'per_page',
            in: 'query',
            required: false,
            schema: new OAT\Schema(type: 'integer', minimum: 1, example: 10),
    ), OAT\Parameter(
            parameter: 'query',
            name: 'query',
            in: 'query',
            required: false,
            schema: new OAT\Schema(type: 'string', minLength: 1),
    ),
]
final class ApiParameter
{
    
}
