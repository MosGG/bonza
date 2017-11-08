<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Mail;

class EmailController extends Controller
{
    public function messageSend(Request $request){

    	$name = $request->input('name');
    	$email = $request->input('email');
    	$message = $request->input('message');
        $phone = $request->input('phone');

    	$messageBody = "Name: " . $name ."<br>";
        $messageBody = "Phone: " . $phone ."<br>";
        $messageBody .= "Email: " . $email ."<br>";
        $messageBody .= "Message: " . $message ."<br>";

    	Mail::send('emails.emailTemplate', ['messageBody' => $messageBody], function ($message) use ($name, $email) {
            $message->from($email, "Messages from ".$name);

            $message->to("sicong@cheee.com.au")->subject("Message From TheMap Website - " . $name);
            });
        sleep(5);
        return '{"sendstatus": 1, "message":"Message has been sent, we will contact you as soon as possible!"}';
    }	
}
