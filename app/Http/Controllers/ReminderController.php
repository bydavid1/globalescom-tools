<?php

namespace App\Http\Controllers;

use App\Jobs\BizigToolReminder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReminderController extends Controller
{
    public function sendReminder()
    {
        BizigToolReminder::dispatch();
        return new JsonResponse(['message' => 'Reminder sent'], 200);
    }
}
