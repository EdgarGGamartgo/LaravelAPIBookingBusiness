<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Services\SendMailService\ISendMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    protected ISendMailService $sendMailService;

    public function __construct(ISendMailService $sendMailService)
    {
        $this->sendMailService = $sendMailService;
    }

    public function send(Request $request) {
        // Mail::send(new SendMail());
         $data = json_decode($request->header('s-m'));
         $mailInfo = [ 'msg' => $data->msg, 'ecran' => $data->ecran ];
         $this->sendMailService->sendMail($mailInfo);
    }


}
