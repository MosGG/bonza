<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;

class TestingController extends Controller
{
    function pdfTesting(){
    	$content = "STARTREAL WEBSITE PROPOSAL";
    	$pdf = PDF::loadview('pdf',['content' => $content])->setPaper('a4');

    	return $pdf->download('test.pdf');
    }

   function login(Request $request){

        return '{"success":true}';

   }
}
