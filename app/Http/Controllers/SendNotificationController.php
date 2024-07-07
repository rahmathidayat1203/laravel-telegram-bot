<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{
    public function index()
    {
        $user = User::all();
        foreach ($user as $key => $u) {
            $u->notify(new TelegramNotification());
        }
    }
}
