<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Mail;

class EmailController extends Controller
{
    public function messageSend(Request $request){
  $fname = $request->input('firstname');
  $lname = $request->input('lastname');
  $phone = $request->input('phone');
  $email = $request->input('email');
  $description = $request->input('description');




  $messageBody = "Name: " . $fname ." ".$lname."<br>";
  $messageBody .= "Email: " . $email ."<br>";
  $messageBody .= "Phone: " . $phone ."<br>";
  $messageBody .= "Description: " . $description ."<br>";

  $email = ["xiaofan@cheee.com.au","eazyee6@gmail.com"];
  Mail::send('emails.emailTemplate', ['messageBody' => $messageBody], function ($m) use ($fname,$email) {
    foreach ($email as $e)
     {
       $m->from('hello@app.com', 'Your Application');

       $m->to($e)->subject("Message From client - " . $fname);
     }


    });
    return '{"sendstatus": 1, "message":"Message has been sent, Bonza will contact you as soon as possible!"}';
  }
}
