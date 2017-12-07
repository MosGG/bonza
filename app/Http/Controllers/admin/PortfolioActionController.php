<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class PortfolioActionController extends Controller
{
    public function portfolioNew(Request $request)
    {

        $id = $request->input('id');
        $title = $request->input('title');
       
        $subtitle = $request->input('subtitle');
      
        $category = $request->input('category');
        $content = $request->input('content');
      
        $medias = $request->input('medias');
        $date = date_create($request->input('date'));
        $brief = $request->input('brief');
       
        $price = $request->input('price');
       
        $discount_price = $request->input('discount_price');
       
        $origin = $request->input('origin');
       
        $stock = $request->input('stock');
        $sales = $request->input('sales');
        $size = $request->input('size');
        $tags = $request->input('tag');
        
        $portfolioId = DB::table('portfolios')->insertGetId(
            ['title' => $title, 'subtitle' => $subtitle, 'origin' => $origin,'category' => $category, 'content' => $content, 'brief' => $brief, 'price' => $price, 'discount_price' => $discount_price, 'stock' => $stock, 'sales' => $sales, 'size' => json_encode($size), 'date' => $date, 'publisher' => $request->session()->get('admin'), 'tag' => json_encode($tags)]
        );

        $hasFeatured = 0;
        if(count($medias) != 0){
            foreach($medias as $media) {
                if($hasFeatured == 0){
                    $hasFeatured = $media['featured'];
                }
            }

            if($hasFeatured == 0){
                $medias[0]['featured']= 1;
            }
        
            foreach ($medias as $media) {
                DB::table('media_portfolio')->insert([
                ['media_id' => $media['id'], 'portfolio_id' => $portfolioId, 'featured' => $media['featured'], 'narrow' => $media['narrow']]
                ]);
            }
        }

        foreach($tags as $tag){
            DB::table('product_tag')->insert(
                ['product_id' => $portfolioId, 'tag_id' => $tag]);
        }
     
        return '{"success":true}';
    }

    public function portfolioEdit(Request $request){

    	$id = $request->input('id');
        $title = $request->input('title');
       
        $subtitle = $request->input('subtitle');
      
        $category = $request->input('category');
        $content = $request->input('content');
      
        $medias = $request->input('medias');
        $date = date_create($request->input('date'));
        $brief = $request->input('brief');
       
        $price = $request->input('price');
       
        $discount_price = $request->input('discount_price');
       
        $origin = $request->input('origin');
       
        $stock = $request->input('stock');
        $sales = $request->input('sales');
        $size = $request->input('size');
        $tags = $request->input('tag');

        DB::table('media_portfolio')->where('portfolio_id', '=', $id)->delete();

        $hasFeatured = 0;
        if(count($medias) != 0){
            foreach($medias as $media) {
                if($hasFeatured == 0){
                    $hasFeatured = $media['featured'];
                }
            }

            if($hasFeatured == 0){
                $medias[0]['featured']= 1;
            }
        
            foreach ($medias as $media) {
                DB::table('media_portfolio')->insert([
                ['media_id' => $media['id'], 'portfolio_id' => $id, 'featured' => $media['featured'], 'narrow' => $media['narrow']]
                ]);
            }
        }

        DB::table('portfolios')
            ->where('id', $id)
            ->update(['title' => $title, 'subtitle' => $subtitle, 'origin' => $origin,'category' => $category, 'content' => $content, 'brief' => $brief, 'price' => $price, 'discount_price' => $discount_price, 'stock' => $stock, 'sales' => $sales, 'size' => json_encode($size), 'date' => $date, 'publisher' => $request->session()->get('admin'), 'tag' => json_encode($tags)]);

        DB::table('product_tag')->where('product_id', '=', $id)->delete();
        foreach($tags as $tag){
            DB::table('product_tag')->insert(
                ['product_id' => $id, 'tag_id' => $tag]);
        }

        return '{"success":true}';
    }

    public function portfolioFeature(Request $request){
    	$id = $request->input('id');
        $featured = $request->input('featured');
         DB::table('portfolios')
            ->where('id', '=', $id)
            ->update(['featured' => $featured]); 

        return '{"success":true}';
    }

    public function  portfolioClient(Request $request){

        $id = $request->input('id');
        $client = $request->input('client');

        if($client == 0){
            $clientSort = DB::table('portfolios')->where('id', '=', $id)->get()[0]->sort;
            DB::table('portfolios')->where('sort', '>', $clientSort)->decrement('sort');
            DB::table('portfolios')
            ->where('id', '=', $id)
            ->update(['client' => $client, 'sort' => 0]); 
            return '{"success":true}';
        }else{
            $clientSort = DB::table('portfolios')->orderBy('sort', 'DESC')->get()[0];
            if(!isset($clientSort)){
                $clientSort = 1;
            }else{
                $clientSort = $clientSort->sort + 1;
            }
            DB::table('portfolios')
            ->where('id', '=', $id)
            ->update(['client' => $client, 'sort' => $clientSort]); 
            return '{"success":true}';
        }
    }

   

    public function portfolioDelete(Request $request){
        $id = $request->input('id');
        $clientSort = DB::table('portfolios')->where('id', '=', $id)->get()[0]->sort;
        if(!$clientSort == 0){
            DB::table('portfolios')->where('sort', '>', $clientSort)->decrement('sort');    
        }
        DB::table('media_portfolio')->where('portfolio_id', '=', $id)->delete();
        DB::table('portfolios')->where('id', $id)->delete();
        return '{"success":true}';
    }

    public function portfolioBan(Request $request){
        $id = $request->input('id');
        $clientSort = DB::table('portfolios')->where('id', '=', $id)->get()[0]->sort;
        if(!$clientSort == 0){
            DB::table('portfolios')->where('sort', '>', $clientSort)->decrement('sort');    
        }
        DB::table('portfolios')
            ->where('id', '=', $id)
            ->update(['client' => 0, 'featured' => 0, 'status' => 0, 'sort' => 0]); 
        return '{"success":true}';
    }


    public function portfolioActive(Request $request){
        $id = $request->input('id');
        DB::table('portfolios')
            ->where('id', '=', $id)
            ->update(['status' => 1]); 
        return '{"success":true}';
    }

    public function clientSort(Request $request){
        $portfolios = $request->input('portfolios');
        foreach($portfolios as $key => $portfolio){
            $sort = $key + 1;
            DB::table('portfolios')
            ->where('id', '=', $portfolio['id'])
            ->update(['sort' => $sort]);
        }

        return '{"success":true}';
    }

    public function partnerNew(Request $request)
    {

        $title = $request->input('title');
        $title_cn = $request->input('title_cn');
        $category = $request->input('category');
        $des = $request->input('description');
        $des_cn = $request->input('description_cn');
        $medias = json_decode($request->input('medias'));
        $date = date_create($request->input('date'));

        $hasFeatured = 0;
        if (count($medias) > 0) {
            foreach($medias as $media) {
                if($hasFeatured == 0){
                    $hasFeatured = $media->id;
                }
            }

            if($hasFeatured == 0){
                $hasFeatured = $medias[0]->id;
            }
        }
        
        $portfolioId = DB::table('partner')->insertGetId(
            ['title' => $title, 'category' => $category, 'title_cn' => $title_cn, 'description' => $des, 'description_cn' => $des_cn,'date' => $date, 'image_id' => $hasFeatured]
        );
     
        return '{"success":true}';
    }

    public function partnerEdit(Request $request){

        $id = $request->input('id');
        $title = $request->input('title');
        $title_cn = $request->input('title_cn');
        $category = $request->input('category');
        $des = $request->input('description');
        $des_cn = $request->input('description_cn');
        $medias = $request->input('medias');
        $date = date_create($request->input('date'));
       
        $hasFeatured = 0;
        if (count($medias) > 0) {
            foreach($medias as $media) {
                if($hasFeatured == 0){
                    $hasFeatured = $media['id'];
                }
            }

            if($hasFeatured == 0){
                $hasFeatured = $medias[0]['id'];
            }
        }

        DB::table('partner')
            ->where('id', $id)
            ->update(['title' => $title, 'category' => $category, 'title_cn' => $title_cn, 'description' => $des, 'description_cn' => $des_cn,'date' => $date, 'image_id' => $hasFeatured]);

        return '{"success":true}';
    }

    public function partnerDelete(Request $request){
        $id = $request->input('id');
        DB::table('partner')->where('id', $id)->delete();
        return '{"success":true}';
    }

    public function partnerFeature(Request $request){
        $id = $request->input('id');
        $featured = $request->input('featured');
        DB::table('partner')
            ->where('id', '=', $id)
            ->update(['featured' => $featured]); 
        return '{"success":true}';
    }

    public function getLatLng($address){
        $address = str_replace(" ", "+", trim($address));
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address="
             . $address . "&key=AIzaSyCJ9dJuakDsSoyFHKkZ8F-S4pixZGXhMfg=";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch); 
        curl_close($ch);
        $result = json_decode($res, true);
        $lat = $result['results'][0]['geometry']['location']['lat'];
        $lng = $result['results'][0]['geometry']['location']['lng'];
        return '{"success":true,"lat":"'.$lat.'","lng":"'.$lng.'"}';
    }


    private function getCategoryById($id){
        return DB::table('category')->where("id", $id)->get()[0];
    }

    private function getThumbById($id){
        return DB::table('media_library')->where("id", $id)->value('src_thumb');
    }

    public function categoryAdd(Request $request)
    {
        $name = $request->input('name');
        $name_cn = $request->input('name_cn');
        $order = $request->input('order');
        $mediaId = $request->input('mediaId');
        $father = $request->input('father');

        if (empty($order)) { $order = 1; }

        if ($father !== '0') {
            $fatherDetail = $this->getCategoryById($father);
            $father_name = $fatherDetail->name;
            $level = $fatherDetail->level + 1;
        } else {
            $father_name = "";
            $level = 1;
        }

        if (!empty($mediaId)){
            $src = $this->getThumbById($mediaId);
        } else {
            $src = "";
        }

        DB::table('category')->insert([
            ['name' => $name, 'name_cn' => $name_cn, 'father' => $father, 'father_name' => $father_name, 'media_id' => $mediaId, 'level' => $level, 'cate_order' => $order, 'src' => $src]
        ]);
        return '{"success":true}';
    }

    public function categoryEdit(Request $request)
    {
        $name = $request->input('name');
        $name_cn = $request->input('name_cn');
        $order = $request->input('order');
        $mediaId = $request->input('mediaId');
        $father = $request->input('father');
        $id = $request->input('id');

        if (empty($order)) { $order = 1; }

        if ($father !== '0') {
            $fatherDetail = $this->getCategoryById($father);
            $father_name = $fatherDetail->name;
            $level = $fatherDetail->level + 1;
        } else {
            $father_name = "";
            $level = 1;
        }

        if (!empty($mediaId)){
            $src = $this->getThumbById($mediaId);
        } else {
            $src = "";
        }

        DB::table('category')
            ->where('id', $id)
            ->update(
                ['name' => $name, 'name_cn' => $name_cn, 'father' => $father, 'father_name' => $father_name, 'media_id' => $mediaId, 'level' => $level, 'cate_order' => $order, 'src' => $src]
            );

        return '{"success":true}';
    }

    public function categoryDelete(Request $request)
    {
        $id = $request->input('id');

        DB::table('category')->where('id', '=', $id)->delete();
        DB::table('portfolios')->where('category', '=', $id)->update(["category" => "1"]);

        return '{"success":true}';
    }
    
    public function tagAdd(Request $request)
    {
        $name = $request->input('name');
        $name_cn = $request->input('name_cn');

        DB::table('tag')->insert([
            ['tag' => $name, 'tag_cn' => $name_cn]
        ]);
        return '{"success":true}';
    }

    public function tagEdit(Request $request)
    {
        $name = $request->input('name');
        $name_cn = $request->input('name_cn');
        $id = $request->input('id');

        DB::table('tag')
            ->where('id', $id)
            ->update(
                ['tag' => $name, 'tag_cn' => $name_cn]
            );
        return '{"success":true}';
    }

    public function tagDelete(Request $request)
    {
        $id = $request->input('id');
        DB::table('tag')->where('id', '=', $id)->delete();
        return '{"success":true}';
    }

    public function orderUpdate(Request $request)
    {
        $id = $request->input('id');
        $recipient = $request->input('recipient');
        $address = $request->input('address');
        $detail = $request->input('detail');
        $total = $request->input('total');
        $status = $request->input('status');
        $paymentstatus = $request->input('paymentstatus');
        $deliverystatus = $request->input('deliverystatus');
        
        $newarray = ['recipient' => $recipient, 'address' => $address, 'detail' => $detail, 'total_price' => $total, 'status' => $status, 'payment_status' => $paymentstatus, 'delivery_status' => $deliverystatus,'update_time'=> time()];

        $old = DB::table('orders')->where('id', $id)->get();
        if ($old[0]->payment_status == 0 and $paymentstatus == 1) {
            $newarray['payment_time'] = time();
        }
        if ($old[0]->delivery_status == 0 and $deliverystatus == 1) {
            $newarray['delivery_time'] = time();
        }

        DB::table('orders')
            ->where('id', $id)
            ->update($newarray);
        return '{"success":true}';
    }

    public function getProductById(Request $request)
    {
        $id = $request->input('id');
        $region = $request->input('region');
        $product = DB::table('portfolios')->where('id', $id)->get();
        if (!empty($product)) {
            if (!empty($product[0]->discount_price)) {
                $product[0]->price = $product[0]->discount_price;
            }
            if ($region == "en") {
                return '{"success":true,"product":{"id":"'.$id.'","title":"'.$product[0]->title.'","unitprice":"'.$product[0]->price.'","quantity":"1","subtotal":"'.$product[0]->price.'"}}';
            } else {
                return '{"success":true,"product":{"id":"'.$id.'","title":"'.$product[0]->title_cn.'","unitprice":"'.$product[0]->price_cn.'","quantity":"1","subtotal":"'.$product[0]->price_cn.'"}}';
            }
        }
        return '{"success":false}';
    }

    public function refundStatusChange(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');
        DB::table('refund')->where("id",$id)->update(['status'=>$status]);
        return '{"success":true}';
    }
}
