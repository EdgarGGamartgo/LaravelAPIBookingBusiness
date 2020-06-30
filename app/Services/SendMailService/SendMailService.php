<?php


namespace App\Services\SendMailService;


use App\Notifications\TaskCompleted;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SendMailService implements ISendMailService
{
    public function sendMail($details)
    {
        //$when = Carbon::now()->addSeconds(10);
        Notification::send(Auth::user(), (new TaskCompleted($details)));//->delay($when));
    }
}
