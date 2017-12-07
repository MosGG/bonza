<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use XeroPrivate;

class PagesController extends Controller
{
    public function home(Request $request){

        // $xero = $this->app->make('XeroPrivate');

        // $contact = $this->app->make('XeroContact');

        $contact = XeroPrivate::load('Accounting\\item');
        var_dump($contact);

        // $contact->setAccountNumber('DMA01');
        // $contact->setContactStatus('ACTIVE');
        // $contact->setName('Mingzhou');
        // $contact->setFirstName('Li');
        // $contact->setLastName('Mingzhou');
        // $contact->setEmailAddress('info@cheee.com.au');
        // $contact->setDefaultCurrency('AUD');

        // var_dump($contact);
        // $xero->save($contact);


        return view('pages.home')->with('action',"");
    }

    public function login(Request $request){
        $req_url = $request->input('req_url');
        return view('pages.login')->with('req_url', $req_url);
    }

    public function register(Request $request){
        return view('pages.register');
    }

    public function product(Request $request, $cate_id = 0){
        $sort = 'sort';
        
        $cate = DB::table('category')->where('id', '=', $cate_id)->get();
        if (!empty($cate)) {
            $product = DB::table('portfolios')->where('status', '=', '1')->where('category',$cate_id)->orderBy($sort)->get();
        } else {
            $product = DB::table('portfolios')->where('status', '=', '1')->orderBy($sort)->get();
        }
       
        $category = DB::table('category')->where('father', '!=', '0')->get();
        

        // $product = DB::table('portfolios')->where('status', '=', '1')->orderBy('sort')->get();
        $page = $request->input("page");
        if (empty($page)) $page = 1;
        $total = count($product);
        $items_per_page = $request->input("item");
        if (empty($items_per_page)) $items_per_page = 24;
        $allPages = ($total%$items_per_page == 0)?(int)Floor($total / $items_per_page):(int)Floor($total / $items_per_page) + 1;
        $start = ($page - 1) * $items_per_page;
        $product = array_slice($product,$start,$items_per_page);
        // $p_array = $this->setPortfolioContent($portfolios, $text);
        $meta_data = array(
            'allPages' => $allPages,
            "items_per_page" => $items_per_page,
            "page" => $page,
            "total" => $total,
                    );
    	return view('pages.product')->with('product', $product)->with('meta', $meta_data)->with('action','product')->with('action','product')->with('category', $category)->with('cate_id', $cate_id);
    }

    public function designers(Request $request){
        $designers = DB::table('portfolios')->groupBy('origin')->orderBy('origin')->get(array('origin'));
        $d_array = array(
            "A" => array(),
            "B" => array(),
            "C" => array(),
            "D" => array(),
            "E" => array(),
            "F" => array(),
            "G" => array(),
            "H" => array(),
            "I" => array(),
            "J" => array(),
            "K" => array(),
            "L" => array(),
            "M" => array(),
            "N" => array(),
            "O" => array(),
            "P" => array(),
            "Q" => array(),
            "R" => array(),
            "S" => array(),
            "T" => array(),
            "U" => array(),
            "V" => array(),
            "W" => array(),
            "X" => array(),
            "Y" => array(),
            "Z" => array(),
            "0-9" => array(),
        );
        foreach ($designers as $value) {
            $initial = substr($value->origin, 0, 1);
            if (is_numeric($initial)) {
                $d_array['0-9'][] = $value->origin;
            } else {
                $d_array[strtoupper($initial)][] = $value->origin;
            }
        }
        return view('pages.designers')->with('action','designers')->with('designers', $d_array);
    }

    public function singleDesigner($designer, Request $request){
        $designer = html_entity_decode($designer);
        $d_info = DB::table('designer')->where('name', $designer)->get();
        $d_info = $d_info[0];
        if (empty($d_info->banner)) {
            $d_info->banner = "/assets/img/single-designer-default.png";
        }

         //change logic here
        $product = DB::table('portfolios')->where('status', '=', '1')->where('origin',$designer)->orderBy('sort')->get();
        $page = $request->input("page");
        if (empty($page)) $page = 1;
        $total = count($product);
        $items_per_page = $request->input("item");
        if (empty($items_per_page)) $items_per_page = 24;
        $allPages = ($total%$items_per_page == 0)?(int)Floor($total / $items_per_page):(int)Floor($total / $items_per_page) + 1;
        $start = ($page - 1) * $items_per_page;
        $product = array_slice($product,$start,$items_per_page);
        $meta_data = array(
            'allPages' => $allPages,
            "items_per_page" => $items_per_page,
            "page" => $page,
            "total" => $total,
                    );

        // var_dump($d_info);
        return view('pages.singledesigner')->with('action','designers')->with('designer_info', $d_info)->with('product', $product)->with('meta', $meta_data);
    }
    public function newarrival(Request $request){
        //change logic here
        $product = DB::table('portfolios')->where('status', '=', '1')->where('client','0')->orderBy('sort')->get();
        $page = $request->input("page");
        if (empty($page)) $page = 1;
        $total = count($product);
        $items_per_page = $request->input("item");
        if (empty($items_per_page)) $items_per_page = 24;
        $allPages = ($total%$items_per_page == 0)?(int)Floor($total / $items_per_page):(int)Floor($total / $items_per_page) + 1;
        $start = ($page - 1) * $items_per_page;
        $product = array_slice($product,$start,$items_per_page);
        $meta_data = array(
            'allPages' => $allPages,
            "items_per_page" => $items_per_page,
            "page" => $page,
            "total" => $total,
                    );
        return view('pages.newarrival')->with('product', $product)->with('meta', $meta_data)->with('action','newarrival');
    }

    public function portfolioCategory($category,Request $request){
        switch ($category) {
            case "past":
            $cate = "Past Projects";
            break;
            case "on-going":
            $cate = "On-Going Projects";
            break;
            case "future":
            $cate = "Future Opportunities";
            break;
        }
        $text = $this->getTranslate($request->input("language"));
        $portfolios = DB::table('portfolios')->where('status', '=', '1')->where('category',$cate)->orderBy('sort')->get();
        $page = $request->input("page");
        if (empty($page)) $page = 1;
        $total = count($portfolios);
        $items_per_page = 9;
        $allPages = ($total%$items_per_page == 0)?(int)Floor($total / $items_per_page):(int)Floor($total / $items_per_page) + 1;
        $start = ($page - 1) * $items_per_page;
        $portfolios = array_slice($portfolios,$start,$items_per_page);
        $p_array = $this->setPortfolioContent($portfolios, $text);
        return view('pages.portfolio')->with('portfolios', $p_array)->with('text', $text)->with('allPages', $allPages)->with('action','project')->with('category',$category);
    }

    private function setPortfolioContent($portfolios, $text){
        $p_array = array();
        foreach($portfolios as $portfolio) {
            $tempArr = array();
            $img = DB::table('media_portfolio')->where('portfolio_id', '=', $portfolio->id)->where("featured", '1')->value('media_id');
            $src = DB::table('media_library')->where('id', '=', $img)->value('src_thumb');
            $tempArr['src'] = $src;
            $tempArr['id'] = $portfolio->id;
            $tempArr['address'] = $portfolio->address;
            $tempArr['suburb'] = $portfolio->suburb;
            $tempArr['state'] = $portfolio->state;
            $tempArr['postcode'] = $portfolio->postcode;
            $tempArr['category_url'] = $this->categorySwitch($portfolio->category);
            $tempArr['roi'] = $portfolio->roi;
            $tempArr['lat'] = $portfolio->lat;
            $tempArr['lng'] = $portfolio->lng;
            if ($text['language'] == 'en'){
                $tempArr['tag'] = $portfolio->tag;
                $tempArr['title'] = $portfolio->title;
                $tempArr['subtitle'] = $portfolio->subtitle;
                $tempArr['content'] = $portfolio->content;
                $tempArr['category'] = $portfolio->category;
                $tempArr['brief'] = $portfolio->brief;
            } else {
                $tempArr['tag'] = $portfolio->tag_cn;
                $tempArr['title'] = $portfolio->title_cn;
                $tempArr['subtitle'] = $portfolio->subtitle_cn;
                $tempArr['content'] = $portfolio->content_cn;
                $tempArr['category'] = $text[$tempArr['category_url']];
                $tempArr['brief'] = $portfolio->brief_cn;
            }
            $p_array[] = $tempArr;
        }
        return $p_array;
    }

    public function contact(Request $request){
        $text = $this->getTranslate($request->input("language"));
        return view('pages.contact')->with('text', $text)->with('action',"contact");
    }

    public function about(Request $request){
        return view('pages.about')->with('action',"about");
    }

    public function termsCondition(Request $request){
        $text = $this->getTranslate($request->input("language"));
        return view('pages.terms')->with('text', $text)->with('action',"");
    }

    public function process(Request $request){
        $text = $this->getTranslate($request->input("language"));
        return view('pages.process')->with('text', $text)->with('action',"process");
    }

    public function processCompany(Request $request){
        $text = $this->getTranslate($request->input("language"));
        return view('pages.processCompany')->with('text', $text)->with('action',"process");
    }

    public function partner($category, Request $request){
        $text = $this->getTranslate($request->input("language"));
        if ($category == "all") {
            $partners = DB::table('partner')->orderBy('date','DESC')->get();
        } else {
            $partners = DB::table('partner')->where('category',$category)->orderBy('date','DESC')->get();
        }

        $page = $request->input("page");
        if (empty($page)) $page = 1;
        $total = count($partners);
        $items_per_page = 6;
        $allPages = ($total%$items_per_page == 0)?(int)Floor($total / $items_per_page):(int)Floor($total / $items_per_page) + 1;
        $start = ($page - 1) * $items_per_page;
        $partners = array_slice($partners,$start,$items_per_page);

        $p_array = array();
        foreach($partners as $portfolio) {
            $tempArr = array();
            $img = $portfolio->image_id;
            $src = DB::table('media_library')->where('id', '=', $img)->value('src_thumb');
            $tempArr['src'] = $src;
            if ($text['language'] == 'en'){
                $tempArr['title'] = $portfolio->title;
                $tempArr['description'] = $portfolio->description;
            } else {
                $tempArr['title'] = $portfolio->title_cn;
                $tempArr['description'] = $portfolio->description_cn;
            }
            $p_array[] = $tempArr;
        }

        return view('pages.partner')->with('portfolios', $p_array)->with('text', $text)->with('allPages', $allPages)->with('action','partner')->with('category',$category);
    }

    public function service(){
        return view('pages.service');
    }

    public function productsingle($id, Request $request){
        $product = DB::table('portfolios')->where('id',$id)->get();
        $product[0]->category = $this->getCategoryById($product[0]->id);
        // $text = $this->getTranslate($request->input("language"));
        // $p_array = $this->setPortfolioContent($product, $text);
        $imgs = DB::table('media_portfolio')->where('portfolio_id', $id)->orderBy('featured','DESC')->get();
        $imgArr = array();
        // $floorplan = array();
        foreach($imgs as $img){
            // if ($img->narrow !== 1) {
                $imgArr[] = DB::table('media_library')->where('id', '=', $img->media_id)->value('src');
            // }
        }
        // var_dump($product[0]);
        return view('pages.productsingle')->with('product', $product[0])->with('imgs',$imgArr);
    }

    public function wishlist(Request $request){
        $wishlist = session('wishlist');
        foreach ($wishlist as $key => $p) {
            $product = DB::table('portfolios')->where('id',$p['id'])->get();
            $imgs = DB::table('media_portfolio')->where('portfolio_id', $p['id'])->orderBy('featured','DESC')->get();
            if (empty($imgs[0]->media_id)) {
                $imgSrc = '/assets/img/default.png';
            } else {
                $imgSrc = DB::table('media_library')->where('id', $imgs[0]->media_id)->value('src_thumb');
            }
            $product[0]->src = $imgSrc;
            $wishlist[$key] = $product[0];
        }
        return view('pages.wishlist')->with('wishlist', $wishlist);
    }

    public function shoppingbag(Request $request){
        $member_bag = DB::table('membership')->where("email", session('member'))->value('shopping_bag');
        $shoppingbag = json_decode($member_bag, true);
        $price = array("product_total"=>0, "delivery"=>0, "subtotal"=>0);
        foreach ($shoppingbag as $key => $p) {
            $product = DB::table('portfolios')->where('id',$p['id'])->get();
            $imgs = DB::table('media_portfolio')->where('portfolio_id', $p['id'])->orderBy('featured','DESC')->get();
            if (empty($imgs[0]->media_id)) {
                $imgSrc = '/assets/img/default.png';
            } else {
                $imgSrc = DB::table('media_library')->where('id', $imgs[0]->media_id)->value('src_thumb');
            }
            $product[0]->src = $imgSrc;
            $product[0]->size = $p['size'];
            $product[0]->qty = $p['qty'];
            $shoppingbag[$key] = $product[0];
            $price['product_total'] += $product[0]->price * $product[0]->qty;
        }
        $price['delivery'] = 15;
        $price['subtotal'] = $price['product_total'] + $price['delivery'];
        return view('pages.shoppingbag')->with('shoppingbag', $shoppingbag)->with('price', $price);
    }

     public function checkout(Request $request){
        $member_bag = DB::table('membership')->where("email", session('member'))->value('shopping_bag');
        $shoppingbag = json_decode($member_bag, true);
        //if nothing return to shoppingbag
        if (empty($shoppingbag)) {
            return redirect()->route('shoppingbag');
        } else {
            $price = array("product_total"=>0, "delivery"=>0, "subtotal"=>0);
            foreach ($shoppingbag as $key => $p) {
                $product = DB::table('portfolios')->where('id',$p['id'])->get();
                $imgs = DB::table('media_portfolio')->where('portfolio_id', $p['id'])->orderBy('featured','DESC')->get();
                if (empty($imgs[0]->media_id)) {
                    $imgSrc = '/assets/img/default.png';
                } else {
                    $imgSrc = DB::table('media_library')->where('id', $imgs[0]->media_id)->value('src_thumb');
                }
                $product[0]->src = $imgSrc;
                $product[0]->size = $p['size'];
                $product[0]->qty = $p['qty'];
                $shoppingbag[$key] = $product[0];
                $price['product_total'] += $product[0]->price * $product[0]->qty;
            }
            $price['delivery'] = 15;
            $price['subtotal'] = $price['product_total'] + $price['delivery'];

            if (empty(session('address')) || empty(session('billing_address'))) {
                $add = DB::table('addressbook')->where("member_id", session('member_id'))->where('default', '1')->get();
                if (!empty($add)) {
                    $address = array(
                        "firstname" => $add[0]->firstname,
                        "lastname" => $add[0]->lastname,
                        "email" => session("member"),
                        "tel" => $add[0]->phone,
                        "add" => $add[0]->address,
                        "add2" => $add[0]->address_second,
                        "city" => $add[0]->city,
                        "state" => $add[0]->state,
                        "postcode" => $add[0]->postcode,
                    );
                } else {
                    $member = DB::table('membership')->where("id", session('member_id'))->get();
                    $address = array(
                        "firstname" => $member[0]->firstname,
                        "lastname" => $member[0]->lastname,
                        "email" => session("member"),
                        "tel" => "",
                        "add" => "",
                        "add2" => "",
                        "city" => "",
                        "state" => "",
                        "postcode" => "",
                    );
                }
                $billing_address = $address;
                $request->session()->put('address', $address);
                $request->session()->put('billing_address', $billing_address);
            }
            return view('pages.checkout')->with('shoppingbag', $shoppingbag)->with('price', $price)->with('address', session("address"))->with('billing_address', session("billing_address"));
        }
    }

    public function checkoutconfirm(){
        if (empty(session('address')) || empty(session('billing_address')) || empty(session('shopping-bag'))) {
            return redirect()->route('checkout');
        } else {
            $member_bag = DB::table('membership')->where("email", session('member'))->value('shopping_bag');
            $shoppingbag = json_decode($member_bag, true);
            $price = array("product_total"=>0, "delivery"=>0, "subtotal"=>0);
            foreach ($shoppingbag as $key => $p) {
                $product = DB::table('portfolios')->where('id',$p['id'])->get();
                $imgs = DB::table('media_portfolio')->where('portfolio_id', $p['id'])->orderBy('featured','DESC')->get();
                if (empty($imgs[0]->media_id)) {
                    $imgSrc = '/assets/img/default.png';
                } else {
                    $imgSrc = DB::table('media_library')->where('id', $imgs[0]->media_id)->value('src_thumb');
                }
                $product[0]->src = $imgSrc;
                $product[0]->size = $p['size'];
                $product[0]->qty = $p['qty'];
                $shoppingbag[$key] = $product[0];
                $price['product_total'] += $product[0]->price * $product[0]->qty;
            }
            $price['delivery'] = 15;
            $price['subtotal'] = $price['product_total'] + $price['delivery'];

            return view('pages.checkoutConfirm')->with('shoppingbag', $shoppingbag)->with('price', $price);
        }
    }

    private function getTranslate($language){
        $lang_key = $language;
        if ($lang_key !== "ch" && $lang_key !== "en") {
            $lang_key = "en";
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
            if (preg_match("/zh-c/i", $lang) || preg_match("/zh/i", $lang)) {
                $lang_key = 'ch';
            }
        }
        $translate = DB::table('translate')->get(array("tkey",$lang_key));
        $text = array();
        foreach ($translate as $value) {
            $text[$value->tkey] = $value->$lang_key;
        }
        return $text;
    }

    private function getCategoryById($id){
        $category = DB::table('category')->where('id', $id)->value('name');
        return $category;
    }

    public function help(Request $request){
        return view('pages.help');
    }

    public function deliver(Request $request){
        return view('pages.deliver');
    }

    public function refund(Request $request){
        return view('pages.refund');
    }

    public function term(Request $request){
        return view('pages.term');
    }

    public function privacy(Request $request){
        return view('pages.privacy');
    }

    public function recruitment(Request $request){
        return view('pages.recruitment');
    }

}
