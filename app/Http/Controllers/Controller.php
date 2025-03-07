<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function sendResponse($operation, $successMsg, $failMsg)
    {
        return [
            'success' => $operation == 1,
            'title' => $operation == 1 ? 'Success' : 'Failed',
            'message' => $operation == 1 ? $successMsg : $failMsg
        ];
    }

}
