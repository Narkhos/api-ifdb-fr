<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as LaravelController;
use OpenApi\Attributes as OA;

#[OA\Info(title: 'IFDB FR API', version: '0.1')]
abstract class Controller extends LaravelController
{
    //
}
