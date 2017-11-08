<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class AppTestingController extends Controller
{
        public function dataCollection(Request $request){

            $skip = $request->input('skip');
            $take = $request->input('take');
            $nodeId = $request->input('nodeId');

            if($nodeId != null){
                $newWorksCount = sizeof(DB::table('portfolios')->where('id', '>' , $nodeId)->get());
                $take = $take + $newWorksCount;
            }

            $featuredWorks = DB::table('portfolios')
                ->skip($skip)
                ->take($take)
                ->orderBy('id', 'DESC')
                ->get();

            foreach($featuredWorks as $work){
                $media = DB::table('media_portfolio')
                            ->where([
                                ['portfolio_id',$work->id],
                                ['featured','1']
                            ])
                            ->get();
                if(sizeof($media) > 0){
                    $media = $media[0]->media_id;
                    $mediaSrc = DB::table('media_library')
                                ->where('id','=',$media)
                                ->get()[0]->src;
                    $work->image = $mediaSrc;            
                }
            }
            return '{"data":'. json_encode($featuredWorks) .'}';

            // $featuredWorks = DB::table('products')->get();
            // return '{"data":'. json_encode($featuredWorks) .'}';
        }

        public function dotaHeroDataCollection(){

            $apiUrl = 'http://api.steampowered.com/IEconDOTA2_570/GetHeroes/v1?key=770F42BD6993D181F19BAEF0A9574269&language=zh'
            $curl  = curl_init('');

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key=770F42BD6993D181F19BAEF0A9574269&account_id=233686618&matches_requested=5',
                CURLOPT_RETURNTRANSFER => 1
            ));

            $heroData = curl_exec($curl);

            dd($heroData)
        }

        public function dotaProfileTestingData(Request $request){

            $curl = curl_init('');
        
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.steampowered.com/IDOTA2Match_570/GetMatchHistory/V001/?key=770F42BD6993D181F19BAEF0A9574269&account_id=233686618&matches_requested=5',
                CURLOPT_RETURNTRANSFER => 1
            ));

            $matchHistory = json_decode(curl_exec($curl))->result->matches;

            $curl = curl_init('');
        
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=770F42BD6993D181F19BAEF0A9574269&steamids=76561198193952346',
                CURLOPT_RETURNTRANSFER => 1
            ));

            $profile = json_decode(curl_exec($curl))->response->players[0];

            // dd($profile);

            foreach ($matchHistory as $key => $value) {
                $curl = curl_init('');
        
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.steampowered.com/IDOTA2Match_570/GetMatchDetails/V001/?match_id=' . $value->match_id . '&key=770F42BD6993D181F19BAEF0A9574269',
                    CURLOPT_RETURNTRANSFER => 1
                ));

                $matchResult = curl_exec($curl);
                $matchHistory[$key]->resultDetail = json_decode($matchResult)->result;
            }

            $fullPlayerResult['players'] = $profile;
            $fullPlayerResult['matches'] = $matchHistory;

            return $fullPlayerResult;
        }

 
    
}
