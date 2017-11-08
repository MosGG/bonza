<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class PortfolioController extends Controller
{
    public function getPortfolioData(Request $request){
        $type = $request->input('type');
        $portfolioData = [];
        switch ($type) {
            case 'all':
               $portfolios  = DB::table('portfolios')->where('client', '=', '1')->where('status', '=', 1)->orderby('sort')->get();
                foreach($portfolios as $portfolio){
                    $media = DB::table('media_portfolio')
                        ->where([
                            ['portfolio_id',$portfolio->id],
                            ['featured','1']
                        ])
                        ->get();
                        if(sizeof($media) > 0){
                            $media = $media[0]->media_id;
                            $mediaSrc = DB::table('media_library')
                                            ->where('id','=',$media)
                                            ->get()[0]->src;
                            $portfolio->image = $mediaSrc;            
                        }
                }
                $portfolioData = $portfolios;
                break;
            case 'brand':
                $portfolios  = DB::table('portfolios')
                                    ->where('category','=','Branding')
                                    ->where('status', '=', 1)
                                    ->orderBy('date', 'DESC')
                                    ->get();
                foreach($portfolios as $portfolio){
                    $media = DB::table('media_portfolio')
                        ->where([
                            ['portfolio_id',$portfolio->id],
                            ['featured','1']
                        ])
                        ->get();
                        if(sizeof($media) > 0){
                            $media = $media[0]->media_id;
                            $mediaSrc = DB::table('media_library')
                                            ->where('id','=',$media)
                                            ->get()[0]->src;
                            $portfolio->image = $mediaSrc;            
                        }
                }
                $portfolioData = $portfolios;
                break;
            case 'design':
            case 'digital':
            case 'media':
            case 'interior':
                $typeCondition = ucfirst($type);
                $portfolios  = DB::table('portfolios')
                                    ->where('category','=',$typeCondition)
                                    ->where('status', '=', 1)
                                    ->orderBy('date', 'DESC')
                                    ->get();
                foreach($portfolios as $portfolio){
                    $imageIds = [];
                    $images = [];
                    $media = DB::table('media_portfolio')
                                ->where('portfolio_id','=',$portfolio->id)
                                ->where('featured', '!=' , 1)
                                ->get();
                    if(sizeof($media) > 0){
                        foreach ($media as $value) {
                                $src = DB::table('media_library')
                                    ->where('id', $value->media_id)
                                    ->get()[0]->src;
                                $imageObj = [];
                                $imageObj['src'] = $src;
                                $imageObj['narrow'] = $value->narrow;
                                array_push($images, $imageObj);
                            }
                        }
                    $portfolio->image = $images;
                }
                $portfolioData = $portfolios;
                break;
            case 'work':
                    $name = $request->input('name');
                    $portfolios = DB::table('portfolios')
                                    ->where('searchIndex','=',$name)
                                    ->get();
                    if(sizeof($portfolios) > 0){
                        $portfolio = $portfolios[0];
                        $imageIds = [];
                        $images = [];
                        $arr = [];
                        $media = DB::table('media_portfolio')
                                ->where('portfolio_id','=',$portfolio->id)
                                ->where('featured', '!=' , 1)
                                ->get();
                        if(sizeof($media) > 0){
                            foreach ($media as $value) {
                                $src = DB::table('media_library')
                                    ->where('id', $value->media_id)
                                    ->get()[0]->src;
                                $imageObj = [];
                                $imageObj['src'] = $src;
                                $imageObj['narrow'] = $value->narrow;
                                array_push($images, $imageObj);
                            }

                        }

                        $portfolio->image = $images;
                        $portfolioData = $portfolio;
                        $portfolioData->type = 'yes';
                    }else{
                        $portfolioData['type'] = 'no';
                        $portfolioData['title'] = $request->input('name');
                    }
                break;         
            default:
                break;
        }
    	return json_encode($portfolioData);
    }

    public function searchAjax(Request $request){
        $q = $request->input('q');
        if ($q == "123") {
            $array = array("很遗憾，没有找到符合你搜索要求的产品");
        } else {
            $array = array("上装","下装","外套","连衣裙","鞋履","配饰","护肤");
        }
        return json_encode($array);
    }
}
