<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ScheduleCall
{
    public static function sendQueryMail(Request $request)
    {
        $postData = self::getPostData($request);
        Mail::send([], [], function($message) use ($postData) {
            $message->from($postData['fromMail'], $postData['fromName']);
            $message->to($postData['to']);
            $message->subject($postData['subject']);
            $message->setBody($postData['body'], 'text/html');
        });
    }

    public static function getPostData(Request $request)
    {
        $requestData = self::getRequestData($request);
        $postData['fromMail'] = 'info@cfsum.com';
        $postData['fromName'] = 'CFSum™';
        $postData['to'] = 'sessions@cfsum.com';
        $postData['subject'] = 'CFSum™ – CFSum new session';
        $postData['body'] = '
        <tr>
           <td height="50" style="font-size:14px;padding-left:20px;background-color:#fffcfc;padding-right:30px;color:#5b5d5f;border-left:1px solid #cccbcb;border-right:1px solid #cccbcb;border-bottom:1px solid #cccbcb">
            <p>
               Subject: Customer details<br>
               Name: ' . $requestData['firstName'] . '<br>
               E-email: ' . $requestData['lastName'] .'<br>
               Phone: ' . $requestData['phone'] . '<br>
               Country: ' . $requestData['country'] . '<br>
               Age: ' . $requestData['age'] . '<br>
            </p>
            <p>Sent from the "OUR ANALYSTS" form</p>	
        </tr>
        ';
        return $postData;
    }

    public static function getRequestData(Request $request)
    {
        $data = $request->all();
        $requestData['firstName'] = array_get($data, 'firstName');
        $requestData['lastName'] = array_get($data, 'lastName');
        $requestData['phone'] = array_get($data, 'phone');
        $requestData['country'] = array_get($data, 'country');
        $requestData['age'] = array_get($data, 'age');
        return $requestData;
    }
}