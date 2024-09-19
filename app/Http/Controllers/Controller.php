<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OAT;

#[OAT\Info(title: 'API', version: '1.0.0')]
class Controller extends BaseController
{

    use AuthorizesRequests,
        ValidatesRequests;
}
