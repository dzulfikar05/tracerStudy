<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    protected function getWaitingTime($graduationDate, $startWorkDate)
    {
        $graduation_date = Carbon::parse($graduationDate);
        $start_work_date = Carbon::parse($startWorkDate);

        $diffInDays = $graduation_date->diffInDays($start_work_date);
        $monthFloat = round($diffInDays / 30.44, 1);
        $formatted = number_format($monthFloat, 1, ',', '');

        return $formatted;
    }
}
