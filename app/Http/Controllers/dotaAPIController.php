<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class dotaAPIController extends Controller
{
    public function executeProgram(){
    	app('App\Http\Controllers\dotaAPIController')->dotaHeroDataCollection();
    }

    private function dotaHeroDataCollection(){

        $apiUrl = 'http://api.steampowered.com/IEconDOTA2_570/GetHeroes/v1?key=770F42BD6993D181F19BAEF0A9574269&language=zh';
        $curl  = curl_init('');

        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => 1
        ));

        $heroData = json_decode(curl_exec($curl))->result->heroes;

        DB::table('heroes_zh')->truncate();

        foreach ($heroData as $key => $hero) {
        	dd($hero->id);
        }
     }
}
